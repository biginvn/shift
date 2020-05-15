<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/26/20
 * Time: 6:24 PM
 */

namespace Bigin\Shift\ColumnManager;


use Bigin\Shift\Validation\IColumnValidator;

abstract class Column implements IColumnMapping
{
    /**
     * @var IColumnValidator
     */
    private $validator;

    /**
     * Header title in Excel file, or key of array input
     * @var string
     */
    private $from;

    /**
     * Column name in table will insert data
     * @var string
     */
    private $column;

    /**
     * Table name will insert data
     * @var string
     */
    private $table;

    /**
     * @var mixed Raw value before format
     */
    private $input;

    /**
     * @var mixed output value after format
     */
    private $output;

    /**
     * @var bool
     */
    private $nullable;


    public function __construct(IColumnValidator $validator)
    {
        $this->validator = $validator;
        $this->nullable = false;
    }

    /**
     * @return IColumnValidator
     */
    public function getValidator(): IColumnValidator
    {
        return $this->validator;
    }

    /**
     * @param IColumnValidator $validator
     * @return Column
     */
    public function setValidator(IColumnValidator $validator): Column
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @return Column
     */
    public function setFrom(string $from): Column
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @param string $column
     * @return Column
     */
    public function setColumn(string $column): Column
    {
        $this->column = $column;
        return $this;
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
     * @return Column
     */
    public function setTable(string $table): Column
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param mixed $input
     * @return Column
     */
    public function setInput($input)
    {
        $this->input = $input;
        $this->getValidator()->setValue($input)->setColumn($this->getFrom());
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param mixed $output
     * @return Column
     */
    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     */
    public function setNullable(bool $nullable)
    {
        $this->nullable = $nullable;
        return $this;
    }

    /**
     * @return mixed|void
     */
    public function prepare()
    {
        if($this->isNullable() && empty($this->getInput())){
            $this->setOutput(null);
            return;
        }
    }
}