<?php

namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;

/**
 * PaymentInfoRequest represents data model of data needed by info request
 * @package DataModel
 */
final class PaymentInfoRequest extends AbstractToArray implements PaymentGatewayRequest
{

    /** @var string id of payment */
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


    /**
     * returns id of payment
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

}