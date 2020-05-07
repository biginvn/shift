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
use Bigin\Shift\Instances\Validation\RelativeValidation;
use Bigin\Shift\Validation\IColumnValidator;
use Illuminate\Support\Facades\DB;

class ColumnRelativeMapping extends Column implements IColumnMapping
{
    /**
     * @var string
     */
    protected $referByTable;

    /**
     * @var string
     */
    protected $referByColumn;

    /**
     * @var string
     */
    protected $referPrimaryColumn;

    /**
     * @var array key (value of "$referByColumn") => value (value of "$referPrimaryColumn")
     */
    protected $indexTable;

    public function __construct(string $from, string $column,array $referBy, IColumnValidator $validator = null)
    {
        if(is_null($validator)){
            $validator = new RelativeValidation($referBy);
        }
        parent::__construct($validator);
        $this->setFrom($from);
        $this->setColumn($column);
        $this->setIndexTable([])->setReferByTable($referBy['table'])->setReferByColumn($referBy['column'])->setReferPrimaryColumn(isset($referBy['primary'])? $referBy['primary'] : 'id');
    }

    /**
     * Do format output value
     * @return mixed
     */
    public function format()
    {
        if(empty($this->getInput())) { // We do not check case empty, because it have been already validated at preparation step.
            return;
        }

        if(isset($this->getIndexTable()[$this->getInput()])){
            $this->setOutput($this->getIndexTable()[$this->getInput()]);
            return;
        }
        $output = DB::table($this->getReferByTable())->where($this->getReferByColumn(), $this->getInput())->first([$this->getReferPrimaryColumn()])->{$this->getReferPrimaryColumn()};
        $this->attachIndexTable($this->getInput(), $output);
        $this->setOutput($output);
    }

    /**
     * @return string
     */
    public function getReferByTable(): string
    {
        return $this->referByTable;
    }

    /**
     * @param string $referByTable
     * @return ColumnRelativeMapping
     */
    public function setReferByTable(string $referByTable): ColumnRelativeMapping
    {
        $this->referByTable = $referByTable;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferByColumn(): string
    {
        return $this->referByColumn;
    }

    /**
     * @param string $referByColumn
     * @return ColumnRelativeMapping
     */
    public function setReferByColumn(string $referByColumn): ColumnRelativeMapping
    {
        $this->referByColumn = $referByColumn;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferPrimaryColumn(): string
    {
        return $this->referPrimaryColumn;
    }

    /**
     * @param string $referPrimaryColumn
     * @return ColumnRelativeMapping
     */
    public function setReferPrimaryColumn(string $referPrimaryColumn): ColumnRelativeMapping
    {
        $this->referPrimaryColumn = $referPrimaryColumn;
        return $this;
    }

    /**
     * @return array
     */
    public function getIndexTable(): array
    {
        return $this->indexTable;
    }

    /**
     * @param array $indexTable
     * @return ColumnRelativeMapping
     */
    public function setIndexTable(array $indexTable): ColumnRelativeMapping
    {
        $this->indexTable = $indexTable;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return ColumnRelativeMapping
     */
    public function attachIndexTable($key, $value): ColumnRelativeMapping {
        $table = $this->getIndexTable();
        $table[$key] = $value;
        $this->setIndexTable($table);
        return $this;
    }



}