<?php

namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;

final class PaymentInfoRequest extends AbstractToArray implements PaymentGatewayRequest
{

    private string $paymentId;

    /**
     * @param string $paymentId Payment ID
     */
    public function __construct(
        string $paymentId
    )
    {
        $this->paymentId = $paymentId;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

}