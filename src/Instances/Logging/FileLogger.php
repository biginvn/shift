<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/25/20
 * Time: 6:15 PM
 */

namespace Bigin\Shift\Instances\Logging;


use Bigin\Shift\Logging\ILog;
use Bigin\Shift\Logging\ILogTypes;

class FileLogger implements ILog
{

    public function write(string $log, string $type = ILogTypes::WARNING): bool
    {
        // TODO: Implement write() method.
    }
}