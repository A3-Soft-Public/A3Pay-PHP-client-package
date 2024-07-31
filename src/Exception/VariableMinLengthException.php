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
class VariableMinLengthException extends VariableLengthException
{
    /**
     * @param string $variable
     * @param int|null $minLen
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct(string $variable, int $minLen, $code = 0, Throwable $previous = null)
    {
        parent::__construct($variable, null, $minLen, $code, $previous);
    }
}