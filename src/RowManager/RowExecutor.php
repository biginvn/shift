<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/26/20
 * Time: 7:34 PM
 */

namespace Bigin\Shift\RowManager;


use Bigin\Shift\ColumnManager\ColumnManager;
use Illuminate\Support\Facades\DB;
use Bigin\Shift\Exception\ValidationException;

class RowExecutor implements IRowExecutor
{

    /**
     * @var ColumnManager
     */
    private $columnManager;

    /**
     * @var array Input data ["first_key" => 10, "second_key" => '2222']
     */
    private $input;

    /**
     * @var string
     */
    private $table;

    /**
     * If the value set to true, should refer to primary Input & Output
     * @var bool
     */
    private $updateExist;

    /**
     * Primary input & out will identify the unique object will be insert & replace in database.
     * Eg: Primary Input = Name, Primary Output = ProductName. Engine will search value of Name in table.ProductName, if it's exist, system will do the update (if updateExist set to true)
     * @var string Header name of input
     */
    private $primaryInput;

    /**
     * @var string Primary column to check if exist
     */
    private $primaryOutput;

    public function __construct()
    {
        $this->setUpdateExist(false);
        $this->setPrimaryInput('id')->setPrimaryOutput('id');
    }

    /**
     * @return ColumnManager
     */
    public function getColumnManager(): ColumnManager
    {
        return $this->columnManager;
    }

    /**
     * @param ColumnManager $columnManager
     * @return RowExecutor
     */
    public function setColumnManager(ColumnManager $columnManager): RowExecutor
    {
        $this->columnManager = $columnManager;
        return $this;
    }

    /**
     * @return array
     */
    public function getInput() : array
    {
        return $this->input;
    }

    /**
     * @param array $input
     * @return RowExecutor
     */
    public function setInput(array $input): RowExecutor
    {
        $this->input = $input;
        return $this;
    }

    /**
     * @return mixed|void
     * @throws ValidationException
     */
    public function execute()
    {
        $row = $this->rowValues();
        /**
         * Update if exist
         */
        if($this->isAvailable() && $this->isUpdateExist()){
            $this->update($row);
            return;
        }

        $this->store($row);

        return;
    }

    /**
     * Fill out value in columns to row
     * @return array
     * @throws ValidationException
     */
    public function rowValues() : array {
        $columns = $this->getColumnManager()->getColumns();
        $row = [];
        foreach ($columns as $column){
            $input = $this->getInput()[$column->getFrom()];
            $column->setInput($input);

            if(!$column->getValidator()->validate()){
                throw new ValidationException($column->getValidator()->getError());
            }
            $column->format();
            $row[$column->getColumn()] = $column->getOutput();
        }
        return $row;
    }

    /**
     * Check if available row
     * @return bool
     */
    public function isAvailable() : bool {
        return DB::table($this->getTable())->where($this->getPrimaryOutput(), $this->getInput()[$this->getPrimaryInput()])
            ->count([$this->getPrimaryOutput()]) > 0;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     * @return RowExecutor
     */
    public function setTable(string $table) : RowExecutor
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Store a row
     * @param array $row
     */
    public function store(array $row): void
    {
        DB::table($this->getTable())->insert($row);// Insert a row to table
    }

    /**
     * Update a row
     * @param array $row
     */
    public function update(array $row): void
    {
        DB::table($this->getTable())->where($this->getPrimaryOutput(), $this->getInput()[$this->getPrimaryInput()])->update($row);
    }

    /**
     * @return bool
     */
    public function isUpdateExist(): bool
    {
        return $this->updateExist;
    }

    /**
     * @param bool $updateExist
     * @return RowExecutor
     */
    public function setUpdateExist(bool $updateExist): RowExecutor
    {
        $this->updateExist = $updateExist;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryInput(): string
    {
        return $this->primaryInput;
    }

    /**
     * @param string $primaryInput
     * @return RowExecutor
     */
    public function setPrimaryInput(string $primaryInput): RowExecutor
    {
        $this->primaryInput = $primaryInput;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryOutput(): string
    {
        return $this->primaryOutput;
    }

    /**
     * @param string $primaryOutput
     * @return RowExecutor
     */
    public function setPrimaryOutput(string $primaryOutput): RowExecutor
    {
        $this->primaryOutput = $primaryOutput;
        return $this;
    }


}