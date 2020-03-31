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
use Bigin\Shift\RowManager\RowExecutor;
use Maatwebsite\Excel\Row;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportOperation
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

    public function __construct(Configuration $config, array $columns)
    {
        $this->config = $config;
        $this->columns = $columns;
        $this->columManager = new ColumnManager($columns);
        $this->rowExecutor = new RowExecutor();
        $this->rowExecutor->setColumnManager($this->getColumManager());
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
     * @return ImportOperation
     */
    public function setConfig(Configuration $config): ImportOperation
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
     * @return ImportOperation
     */
    public function setColumns(array $columns): ImportOperation
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
     * @return ImportOperation
     */
    public function setRowExecutor(RowExecutor $rowExecutor): ImportOperation
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
     * @return ImportOperation
     */
    public function setColumManager(ColumnManager $columManager): ImportOperation
    {
        $this->columManager = $columManager;
        return $this;
    }


    public function execute(){
        $collection = (new FastExcel())->import($this->config->filePath);
        $this->rowExecutor->setTable('products');
        foreach($collection as $row){
            $this->rowExecutor->setInput($row);
            $this->rowExecutor->execute();
        }
    }

}