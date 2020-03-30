<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/26/20
 * Time: 6:24 PM
 * Expectation chain: Get Input -> Do Format -> Provide Output
 */

namespace Bigin\Shift\ColumnManager;


interface IColumnMapping
{
    /**
     * Get, set From attribute (the header)
     * @return string
     */
    public function getFrom():string;
    public function setFrom(string $key):Column;

    /**
     * Get, set column name, in table will insert
     * @return string
     */
    public function getColumn():string;
    public function setColumn(string $column):Column;

    /**
     * Get, set table name will insert
     * @return string
     */
    public function getTable():string;
    public function setTable(string $table):Column;

    /**
     * Get raw value was not parsed
     * @return mixed
     */
    public function getInput();

    /**
     * Do by the chain: receive input value -> do prepare() -> do format() -> set output()
     * @return mixed
     */
    public function prepare();

    /**
     * Do format output value
     * @return mixed
     */
    public function format();

    /**
     * Get finally output value
     * @return mixed
     */
    public function getOutput();
}