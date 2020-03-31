<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/26/20
 * Time: 6:46 PM
 */

namespace Bigin\Shift\Instances\ColumnManager;


use Bigin\Shift\ColumnManager\Column;
use Bigin\Shift\ColumnManager\IColumnMapping;
use Bigin\Shift\Validation\IColumnValidator;

class ColumnDirectMapping extends Column implements IColumnMapping
{
    public function __construct(string $from, string $column, IColumnValidator $validator)
    {
        parent::__construct($validator);
        $this->setFrom($from);
        $this->setColumn($column);
    }

    /**
     * Do format output value
     * @return mixed
     */
    public function format()
    {
        if(!empty($this->getInput())) {
            $this->setOutput($this->getInput());
            return;
        }
    }
}