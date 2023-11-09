<?php

namespace A3Soft\A3PayPhpClient\Exception;

use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse;
use Throwable;

class CurlRequestException extends \Exception
{
    private CurlResponse $curlResponse;
    public function __construct($message, CurlResponse $curlResponse, $code = 0, Throwable $previous = null)
    {
        $this->curlResponse = $curlResponse;
        parent::__construct($message, $code, $previous);
    }

    public function getCurlResponse(): CurlResponse
    {
        return $this->curlResponse;
    }


}