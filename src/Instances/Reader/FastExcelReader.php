<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 4/5/20
 * Time: 8:00 AM
 */

namespace Bigin\Shift\Instances\Reader;


use Bigin\Shift\Reader\IReader;
use Rap2hpoutre\FastExcel\FastExcel;

class FastExcelReader implements IReader
{
    /**
     * Path to read excel file
     * @var string
     */
    private $path = '';

    /**
     * Row data is reading
     * @var array
     */
    private $row = [];

    /**
     * All rows after first read
     * @var array
     */
    private $data = [];

    /**
     * @param int Current index cursor is reading
     */
    private $index = -1;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Read a row, and list out data into array.
     * @return array
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     */
    public function nextRow(): array
    {
        if(empty($this->path)) {
            return [];
        }

        if($this->index == -1) {
            $this->data = (new FastExcel())->import($this->path);
            $this->index = 0;
        } else {
            $this->index++;
        }

        if(isset($this->data[$this->index])){
            return $this->row = $this->data[$this->index];
        }

        $this->reset();
        return [];
    }

    /**
     * Default value for all variables;
     */
    public function reset() : void {
        $this->index = -1;
        $this->row = [];
        $this->data = [];
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
     * @return FastExcelReader
     */
    public function setPath(string $path): FastExcelReader
    {
        $this->path = $path;
        return $this;
    }


}