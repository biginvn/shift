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
    const VALIDATION_ERROR                  = "VALIDATION_ERROR";
    const SUCCESS                           = "SUCCESS";
    const UNEXPECTED_ERROR                  = "UNEXPECTED_ERROR";
    const WARNING                           = "WARNING";
}