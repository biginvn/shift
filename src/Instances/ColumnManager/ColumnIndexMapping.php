<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/26/20
 * Time: 6:46 PM
 */

namespace Bigin\Shift\Instances\ColumnManager;


use Bigin\Shift\ColumnManager\Column;
use Bigin\Shift\ColumnManager\IColumnMapping;
use Bigin\Shift\Instances\Validation\QuickValidation;
use Bigin\Shift\Validation\IColumnValidator;

class ColumnIndexMapping extends Column implements IColumnMapping
{
    /**
     * Mapping by index table
     * ColumnIndexMapping constructor.
     * @param string $from
     * @param string $column
     * @param array $indexTable
     * @param IColumnValidator $validator
     */
    protected $indexTable = [];

    public function __construct(string $from, string $column, array $indexTable, IColumnValidator $validator = null)
    {
        $patternValidation = 'in:'.implode(",",array_keys($indexTable));
        if(is_null($validator)){
            $validator = new QuickValidation($patternValidation);
        }
        parent::__construct($validator);
        $this->setFrom($from);
        $this->setColumn($column);
        $this->indexTable = $indexTable;

    }

    /**
     * Do format output value
     * @return mixed
     */
    public function format()
    {
        if(!empty($this->getInput())) {
            $this->setOutput($this->getIndexTable()[$this->getInput()]);
        }
    }

    /**
     * @return mixed
     */
    public function getIndexTable()
    {
        return $this->indexTable;
    }

    /**
     * @param mixed $indexTable
     * @return ColumnIndexMapping
     */
    public function setIndexTable($indexTable)
    {
        $this->indexTable = $indexTable;
        return $this;
    }

}