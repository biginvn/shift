<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/22/20
 * Time: 10:51 AM
 */

namespace Bigin\Shift\Instances\Validation;


use Bigin\Shift\Configuration\Configuration;
use Bigin\Shift\Validation\ColumnValidator;
use Bigin\Shift\Validation\IColumnValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RelativeValidation extends ColumnValidator implements IColumnValidator
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
     * @var array value already validated
     */
    protected $indexTable;

    /**
     * @var bool
     */
    protected $trim;

    /**
     * @var bool
     */
    protected $ignoreCase;

    /**
     * RelativeValidation constructor.
     * @param array
     */
    public function __construct(array $referBy)
    {
        $this->setReferByTable($referBy['table'])->setReferByColumn($referBy['column'])->setReferPrimaryColumn(isset($referBy['primary'])? $referBy['primary'] : 'id');
        $this->setIndexTable([])->setTrim(true)->setIgnoreCase(true);

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
     * @return RelativeValidation
     */
    public function setReferByTable(string $referByTable): RelativeValidation
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
     * @return RelativeValidation
     */
    public function setReferByColumn(string $referByColumn): RelativeValidation
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
     * @return RelativeValidation
     */
    public function setReferPrimaryColumn(string $referPrimaryColumn): RelativeValidation
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
     * @return RelativeValidation
     */
    public function setIndexTable(array $indexTable): RelativeValidation
    {
        $this->indexTable = $indexTable;
        return $this;
    }

    /**
     * @param $value
     * @return RelativeValidation
     */
    public function attachIndexTable($value): RelativeValidation {
        $table = $this->getIndexTable();
        $table[] = $value;
        $this->setIndexTable($table);
        return $this;
    }

    public function validate(): bool
    {
        $value = $this->getValue();

        if($this->isTrim()){
            $value = trim($value);
        }

        if($this->isIgnoreCase()){
            $isAvailable = in_array(mb_strtolower($value), array_map("mb_strtolower", $this->getIndexTable()));
        } else {
            $isAvailable = in_array($value, $this->getIndexTable());
        }

        if($isAvailable){
            return true;
        }

        $count = DB::table($this->getReferByTable())->where($this->getReferByColumn(), $value)->count([$this->getReferPrimaryColumn()]);
        if($count > 0){
            $this->attachIndexTable($value);
            return true;
        }

        $this->setError("System did not find $value in database");
        return false;
    }

    /**
     * @return bool
     */
    public function isTrim(): bool
    {
        return $this->trim;
    }

    /**
     * @param bool $trim
     * @return RelativeValidation
     */
    public function setTrim(bool $trim): RelativeValidation
    {
        $this->trim = $trim;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIgnoreCase(): bool
    {
        return $this->ignoreCase;
    }

    /**
     * @param bool $ignoreCase
     * @return RelativeValidation
     */
    public function setIgnoreCase(bool $ignoreCase): RelativeValidation
    {
        $this->ignoreCase = $ignoreCase;
        return $this;
    }
}