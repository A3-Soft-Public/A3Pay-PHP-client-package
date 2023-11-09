<?php
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

interface PaymentGatewayRequest
{
    public function toArray(bool $ignoreNull = false, bool $recursive = false, bool $stdClassIfEmpty = false);
}
