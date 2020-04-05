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
use Illuminate\Support\Carbon;

class FileLogger implements ILog
{

    /**
     * [datetime][type]: Content
     * @var string
     */
    protected $template = "[%s] [%s] - Line [%d]: %s". PHP_EOL;

    /**
     * File path for writing output
     * @var string
     */
    protected $path;

    public function __construct(string $path = null)
    {
        if(is_null($path)){
            $this->path = storage_path('logs/shift-import-'. Carbon::now()->format('d_m_H_i'));
        } else {
            $this->path = $path;
        }
    }

    /**
     * @param int $line
     * @param string $log
     * @param string $type
     * @return bool
     */
    public function write(int $line, string $log, string $type = ILogTypes::WARNING): bool
    {
        file_put_contents($this->getPath(), sprintf($this->template, Carbon::now()->format('H:i:v'), $type, $line, $log), FILE_APPEND);
        return true;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return FileLogger
     */
    public function setPath(string $path): FileLogger
    {
        $this->path = $path;
        return $this;
    }
}