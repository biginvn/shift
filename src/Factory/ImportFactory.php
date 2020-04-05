<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/25/20
 * Time: 6:12 PM
 */

namespace Bigin\Shift\Operation;


use Bigin\Shift\ColumnManager\Column;
use Bigin\Shift\ColumnManager\ColumnManager;
use Bigin\Shift\Configuration\Configuration;
use Bigin\Shift\Exception\ValidationException;
use Bigin\Shift\Logging\ILogTypes;
use Bigin\Shift\RowManager\RowExecutor;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportFactory
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var Column[]
     */
    protected $columns;

    /**
     * @var RowExecutor
     */
    private $rowExecutor;

    /**
     * @var ColumnManager
     */
    private $columManager;

    /**
     * Start at line: Define row number in Excel, the first row of data table. Eg: If your header title was put on line 1 in Excel, so the first row of data will be put on line 2.
     * @var int
     */
    private $startAtLine = 2;

    public function __construct(Configuration $config, array $columns)
    {
        $this->config = $config;
        $this->columns = $columns;
        $this->columManager = new ColumnManager($columns);
        $this->rowExecutor = new RowExecutor();
        $this->rowExecutor->setColumnManager($this->getColumManager());
    }

    /**
     * @return int
     */
    public function getStartAtLine(): int
    {
        return $this->startAtLine;
    }

    /**
     * @param int $startAtLine
     * @return ImportFactory
     */
    public function setStartAtLine(int $startAtLine): ImportFactory
    {
        $this->startAtLine = $startAtLine;
        return $this;
    }

    /**
     * @return Configuration
     */
    public function getConfig(): Configuration
    {
        return $this->config;
    }

    /**
     * @param Configuration $config
     * @return ImportFactory
     */
    public function setConfig(Configuration $config): ImportFactory
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param Column[] $columns
     * @return ImportFactory
     */
    public function setColumns(array $columns): ImportFactory
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @return RowExecutor
     */
    public function getRowExecutor(): RowExecutor
    {
        return $this->rowExecutor;
    }

    /**
     * @param RowExecutor $rowExecutor
     * @return ImportFactory
     */
    public function setRowExecutor(RowExecutor $rowExecutor): ImportFactory
    {
        $this->rowExecutor = $rowExecutor;
        return $this;
    }

    /**
     * @return ColumnManager
     */
    public function getColumManager(): ColumnManager
    {
        return $this->columManager;
    }

    /**
     * @param ColumnManager $columManager
     * @return ImportFactory
     */
    public function setColumManager(ColumnManager $columManager): ImportFactory
    {
        $this->columManager = $columManager;
        return $this;
    }

    /**
     * Just do validate, do not execute any importing process.
     * @return void
     */
    public function walkThrough() : void {
        $readingLine = $this->getStartAtLine();
        while($row = $this->getConfig()->getReader()->nextRow()){
            $this->validateRow($row, $readingLine);
            $readingLine++;
        }
        $this->getConfig()->getReader()->reset();
    }

    /**
     * Support for walkThrough. Loop all columns and validate, write errors to log if validation exception happen.
     * @param array $row
     * @param int $line
     */
    private function validateRow(array $row, int $line) : void {
        $columns = $this->getRowExecutor()->getColumnManager()->getColumns();
        foreach ($columns as $column) {
            $input = $row[$column->getFrom()];
            $column->setInput($input);
            if (!$column->getValidator()->validate()) {
                $this->getConfig()->getLog()->write($line, __('shift::shift.validation_error', ['error'    => $column->getValidator()->getError()]), ILogTypes::VALIDATION_ERROR);
            }
        }
    }

    /**
     * Execute import process
     * @return bool
     */
    public function execute() : bool {
        DB::beginTransaction();
        $readingLine = $this->getStartAtLine();
        try {
            while($row = $this->getConfig()->getReader()->nextRow()){
                $this->importRow($row);
                $this->getConfig()->getLog()->write($readingLine,__('shift::shift.success'), ILogTypes::SUCCESS);
                $readingLine++;
            }
        }
        catch (ValidationException $e) {
            DB::rollBack();
            $this->getConfig()->getLog()->write($readingLine, __('shift::shift.validation_error', ['error'    => $e->getMessage()]), ILogTypes::VALIDATION_ERROR);
            return false;
        }
        catch (\Exception $e){
            DB::rollBack();
            $this->getConfig()->getLog()->write($readingLine, __('shift::shift.unexpected_error', ['error'    => $e->getMessage()]), ILogTypes::UNEXPECTED_ERROR);
            return false;
        }
        DB::commit();
        return true;
    }

    /**
     * @param array $row
     * @throws ValidationException
     */
    public function importRow(array $row){
        $this->rowExecutor->setInput($row);
        $this->rowExecutor->execute();
    }

}