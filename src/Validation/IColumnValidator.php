<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/22/20
 * Time: 10:51 AM
 */

namespace Bigin\Shift\Validation;


interface IColumnValidator
{

    public function getValue();
    public function getColumn():string;
    public function setColumn(string $column):ColumnValidator;

    public function setValue($value) : ColumnValidator;
    public function validate() : bool;
    public function setError(string $error) : ColumnValidator;
    public function getError(): string ;
}