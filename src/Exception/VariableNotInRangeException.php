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
class VariableNotInRangeException extends \Exception
{

    /**
     * @param int|float $variable
     * @param string $varName
     * @param int|null $minValue
     * @param int|null $maxValue
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($variable, string $varName, ?int $minValue = null, ?int $maxValue = null, int $code = 0, Throwable $previous = null)
    {
        if ($minValue !== null && $variable < $minValue) {
            $message = "Variable \"$varName\" with value $variable is smaller than minValue: $minValue!";
        } elseif ($maxValue !== null && $variable > $maxValue) {
            $message = "Variable \"$varName\" with value $variable is greater than maxValue: $maxValue!";
        } else {
            $message = "Variable \"$varName\" with value $variable is not in range!";
        }

        parent::__construct($message, $code, $previous);
    }
}