<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Exception;

use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentRequest;
use Throwable;

/**
 * VariableNotGuidException is thrown when variable value does not match guid regex
 * For example:
 * PaymentRequest class need methodId as construct parameter.
 * If methodId is not regex, the VariableNotGuidException is thrown
 * @package Exception
 */
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