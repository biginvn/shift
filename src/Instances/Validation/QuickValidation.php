<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/22/20
 * Time: 10:51 AM
 */

namespace Bigin\Shift\Instances\Validation;


use Bigin\Shift\Configuration\Configuration;
use Bigin\Shift\Validation\ColumnValidator;
use Bigin\Shift\Validation\IColumnValidator;
use Illuminate\Support\Facades\Validator;

class QuickValidation extends ColumnValidator implements IColumnValidator
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * QuickValidation constructor.
     * @param string $validatePattern
     */
    public function __construct(string $validatePattern)
    {
        $this->pattern = $validatePattern;
    }

    public function validate(): bool
    {
        $validator = Validator::make([ $this->getColumn() => $this->getValue()], [
             $this->getColumn() => $this->getPattern(),
        ]);
        if ($validator->fails()) {
            $this->setError(implode(". ",$validator->errors()->getMessages()[$this->getColumn()]));
            return false;
        }
        return true;
    }

    /**
     * @param string $pattern
     * @return QuickValidation
     */
    public function setPattern(string $pattern): QuickValidation
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }
}