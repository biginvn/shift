<?php
/**
 * Created by PhpStorm.
 * User: minhtruong
 * Date: 3/29/20
 * Time: 11:08 AM
 */
namespace Bigin\Shift\Exception;
use Throwable;

class ValidationException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}