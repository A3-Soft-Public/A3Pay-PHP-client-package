<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Exception;

use A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester;
use Throwable;

/**
 * VariableNotUrlException is thrown when variable value does not match Url structure.
 * For example:
 * PaymentGatewayRequester needs link for construct, the link must be Url,
 * so when link variable does not match Url structure, PaymentGatewayRequester will be thrown
 * @package Exception
 */
class VariableNotUrlException extends \Exception
{

    /**
     * @param string $variable
     * @param string $varName
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $variable, string $varName, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Variable \"$varName\" with value $variable does not meet the URL conditions.", $code, $previous);
    }
}