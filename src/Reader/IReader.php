<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 4/5/20
 * Time: 7:55 AM
 */

namespace Bigin\Shift\Reader;


interface IReader
{
    /**
     * Read a row, and list out data into array.
     * @return array
     */
    public function nextRow() : array;

    /**
     * Reset all variables.
     */
    public function reset() : void;

}