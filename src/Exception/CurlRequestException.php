<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Exception;

use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse;
use Throwable;

/**
 * This exception is thrown when there is an error while trying to make request to payment gateway api
 * @package Exception
 */
class CurlRequestException extends \Exception
{
    /** @var CurlResponse  */
    private CurlResponse $curlResponse;
    public function __construct($message, CurlResponse $curlResponse, $code = 0, Throwable $previous = null)
    {
        $this->curlResponse = $curlResponse;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns CurlResponse object
     * @return CurlResponse
     */
    public function getCurlResponse(): CurlResponse
    {
        return $this->curlResponse;
    }


}