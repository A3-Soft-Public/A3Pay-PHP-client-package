<?php

namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;
use A3Soft\A3PayPhpClient\Exception\VariableNotGuidException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;

/**
 * PaymentInfoRequest represents data model of data needed by info request
 * @package DataModel
 */
final class PaymentInfoRequest extends AbstractToArray implements PaymentGatewayRequest
{

    /** @var string id of payment GUID*/
    private string $paymentId;

    /**
     * @param string $paymentId Payment ID
     * @throws VariableNotGuidException
     */
    public function __construct(
        string $paymentId
    )
    {
        $this->paymentId = $paymentId;

        Utils::checkValueGuid($paymentId, 'paymentId');
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