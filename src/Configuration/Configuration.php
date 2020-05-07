<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/21/20
 * Time: 10:07 AM
 */

namespace Bigin\Shift\Configuration;


use Bigin\Shift\Instances\Logging\FileLogger;
use Bigin\Shift\Instances\Reader\FastExcelReader;
use Bigin\Shift\Logging\ILog;
use Bigin\Shift\Reader\IReader;

class Configuration
{
    /**
     * Input file path for Import function
     * @var string $filePath
     */
    public $filePath;

    /**
     * Reader for input file
     * @var IReader
     */
    public $reader;

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
        $this->reader = new FastExcelReader($this->filePath);
    }

    /**
     * @return IReader
     */
    public function getReader(): IReader
    {
        return $this->reader;
    }

    /**
     * @param IReader $reader
     * @return Configuration
     */
    public function setReader(IReader $reader): Configuration
    {
        $this->reader = $reader;
        return $this;
    }


    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     * @return Configuration
     */
    public function setFilePath(string $filePath): Configuration
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * @return array
     */
    public function getMappingColumns(): array
    {
        return $this->mappingColumns;
    }

    /**
     * @param array $mappingColumns
     * @return Configuration
     */
    public function setMappingColumns(array $mappingColumns): Configuration
    {
        $this->mappingColumns = $mappingColumns;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStopOnFailure(): bool
    {
        return $this->stopOnFailure;
    }

    /**
     * @param bool $stopOnFailure
     * @return Configuration
     */
    public function setStopOnFailure(bool $stopOnFailure): Configuration
    {
        $this->stopOnFailure = $stopOnFailure;
        return $this;
    }

    /**
     * @return bool
     */
    public function isImportable(): bool
    {
        return $this->isImportable;
    }

    /**
     * @param bool $isImportable
     * @return Configuration
     */
    public function setIsImportable(bool $isImportable): Configuration
    {
        $this->isImportable = $isImportable;
        return $this;
    }

    /**
     * @return ILog
     */
    public function getLog(): ILog
    {
        return $this->log;
    }

    /**
     * @param ILog $log
     * @return Configuration
     */
    public function setLog(ILog $log): Configuration
    {
        $this->log = $log;
        return $this;
    }


}