<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Exception;

use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\Payment;
use Throwable;

/**
 * VariableNotContainsException is thrown when there are some allowed values.
 * For example:
 * In Payment class, there is field paymentId.
 * It defines type of payment from 3 allowed values.
 * If <b>paymentId</b> does not match required value, VariableNotContainsException will be thrown
 * @package Exception
 */
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