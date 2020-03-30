<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/26/20
 * Time: 6:37 PM
 */

namespace Bigin\Shift\RowManager;


interface IRowExecutor
{
    /**
     * Execute import
     * @return mixed
     */
    public function execute();

    /**
     * @param array $input
     * @return RowExecutor
     */
    public function setInput(array $input):RowExecutor;
    public function getInput():array;

    public function setTable(string $table) : RowExecutor;
    public function getTable() : string;

    /**
     * @var array
     */
    public function store(array $row) : void ;

    /**
     * Update a row
     * @param array $row
     */
    public function update(array $row) : void ;
}