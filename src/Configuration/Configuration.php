<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/21/20
 * Time: 10:07 AM
 */

namespace Bigin\Shift\Configuration;


use Bigin\Shift\Instances\Logging\FileLogger;
use Bigin\Shift\Logging\ILog;

class Configuration
{
    /**
     * Input file path for Import function
     * @var string $filePath
     */
    public $filePath;

    /**
     * @var array mapping column, the first time is just for defining 1 - 1
     */
    public $mappingColumns;

    /**
     * Stop executing & rollback when got issue?
     * @var bool
     */
    public $stopOnFailure = true;

    /**
     * Is importable will describe Import/Export functional
     * @var bool
     */
    public $isImportable = true;

    /**
     * @var ILog
     */
    public $log;

    public function __construct(string $filePath, $stopOnFailure = true, ILog $log = null)
    {
        $this->filePath = $filePath;
        $this->stopOnFailure = $stopOnFailure;
        $this->log = is_null($log) ? new FileLogger() : $log;
    }
}