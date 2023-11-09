<?php

namespace A3Soft\A3PayPhpClient\Exception;

use Throwable;

class VariableNotContainsException extends \Exception
{

    /**
     * @param string $variable
     * @param string $varName
     * @param string[] $contains
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $variable, string $varName, array $contains, int $code = 0, Throwable $previous = null)
    {
        $containsStr = implode(',', $contains);
        parent::__construct("Variable \"$varName\" with value $variable does not meet the conditions [$containsStr]", $code, $previous);
    }
}