<?php

namespace A3Soft\A3PayPhpClient\Exception;

use Throwable;

class VariableLengthException extends \Exception
{
    /**
     * @param string $variable
     * @param int|null $maxLen
     * @param int|null $minLen
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct(string $variable, ?int $maxLen = null, ?int $minLen = null,  $code = 0, Throwable $previous = null)
    {
        if($minLen !== null && $maxLen !== null) {
            $message = "The field \"$variable\" must be a string between minimum length of $minLen and maximum length of $maxLen.";
        } elseif ($minLen !== null) {
                $message = "The field \"$variable\" must be a string with a minimum length of $minLen.";
        } else {
            $message = "The field \"$variable\" must be a string with a maximum length of $maxLen.";
        }
        parent::__construct($message, $code, $previous);
    }
}