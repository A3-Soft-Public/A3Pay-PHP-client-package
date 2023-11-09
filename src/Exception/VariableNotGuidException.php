<?php

namespace A3Soft\A3PayPhpClient\Exception;

use Throwable;

class VariableNotGuidException extends \Exception
{

    /**
     * @param string $variable
     * @param string $varName
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $variable, string $varName, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Variable \"$varName\" with value $variable does not meet the Guid conditions.", $code, $previous);
    }
}