<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Exception;

use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentRequest;
use Throwable;

/**
 * VariableLengthException is thrown when trying to construct Helper object,
 * and API has limited string or int field length
 * For example:
 * If you are going to use PaymentRequest,
 * you need currency value for object construction.
 * Currency has string type with maximum length of 3 characters.
 * So if you pass currency longer than 3 characters, exception will be thrown.
 * @package Exception
 */
class VariableLengthException extends \Exception
{
    /**
     * @param string $variable
     * @param int|null $maxLen
     * @param int|null $minLen
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct(string $variable, ?int $maxLen = null, ?int $minLen = null, $code = 0, Throwable $previous = null)
    {
        if ($minLen !== null && $maxLen !== null) {
            $message = "The field \"$variable\" must be a string between minimum length of $minLen and maximum length of $maxLen.";
        } elseif ($minLen !== null) {
            $message = "The field \"$variable\" must be a string with a minimum length of $minLen.";
        } else {
            $message = "The field \"$variable\" must be a string with a maximum length of $maxLen.";
        }
        parent::__construct($message, $code, $previous);
    }
}