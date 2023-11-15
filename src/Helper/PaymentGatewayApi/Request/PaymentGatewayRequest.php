<?php
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

/**
 * PaymentGatewayRequest interface represents array cast option of class
 * @package Interface
 */
interface PaymentGatewayRequest
{
    public function toArray(bool $ignoreNull = false, bool $recursive = false, bool $stdClassIfEmpty = false);
}
