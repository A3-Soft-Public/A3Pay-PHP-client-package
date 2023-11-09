<?php

namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Notify;

use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use Exception;

final class PaymentNotifyData extends AbstractToArray
{
    /** @var string  */
    private string $paymentId;
    /** @var string  */
    private string $status;

    /**
     * @param string $paymentId
     * @param string $status
     */
    public function __construct(string $paymentId, string $status)
    {
        $this->paymentId = $paymentId;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }


    /**
     * @param array $responseArray
     * @return self
     * @throws Exception
     */
    public static function fromArray(array $responseArray): self
    {
        if (!array_key_exists('status', $responseArray)) {
            throw new Exception('Array key \"Status\" missing in response data!');
        }
        if (!array_key_exists('paymentId', $responseArray)) {
            throw new Exception('Array key \"PaymentId\" missing in response data!');
        }
        if (gettype($responseArray['status']) !== 'string') {
            throw new Exception('Array key \"status\" type does not match string type!');
        }
        if (gettype($responseArray['paymentId']) !== 'string') {
            throw new Exception('Array key \"PaymentId\" type does not match string type!');
        }

        return new static($responseArray['paymentId'], $responseArray['status']);
    }
}