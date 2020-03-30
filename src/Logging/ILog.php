<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/25/20
 * Time: 6:15 PM
 */

namespace Bigin\Shift\Logging;


interface ILog
{
    public function write(string $log, string $type = ILogTypes::WARNING) : bool;

}