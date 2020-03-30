<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/25/20
 * Time: 6:18 PM
 */

namespace Bigin\Shift\Logging;


interface ILogTypes
{
    const ERROR                 = "ERROR";
    const SUCCESS               = "SUCCESS";
    const EXCEPTION             = "EXCEPTION";
    const WARNING               = "WARNING";
}