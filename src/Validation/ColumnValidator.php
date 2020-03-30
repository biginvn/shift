<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/26/20
 * Time: 7:34 PM
 */

namespace Bigin\Shift\Validation;


abstract class ColumnValidator implements IColumnValidator
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $error;

    /**
     * @var string column name
     */
    private $column;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getColumn():string {
        return $this->column;
    }

    /**
     * @param string $column
     * @return ColumnValidator
     */
    public function setColumn(string $column):ColumnValidator{
        $this->column = $column;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return ColumnValidator
     */
    public function setValue($value) : ColumnValidator
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     * @return ColumnValidator
     */
    public function setError(string $error) : ColumnValidator
    {
        $this->error = $error;
        return $this;
    }

}