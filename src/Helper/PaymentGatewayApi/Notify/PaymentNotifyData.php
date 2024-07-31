<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Notify;

use A3Soft\A3PayPhpClient\Exception\VariableNotContainsException;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;
use Exception;

/**
 * PaymentNotifyData represents data model for data provided by notify hook.
 * When payment is processed notification hook is called with this data.
 * @package DataModel
 */
final class PaymentNotifyData extends AbstractToArray
{
    /** @var string id of payment returned by PaymentResponse */
    private string $paymentId;
    /** @var string can be Created, New, Authorized, Declined, Reversed, Captured, Error */
    private string $status;

    /**
     * @param string $paymentId id of payment returned by PaymentResponse
     * @param string $status can be Created, New, Authorized, Declined, Reversed, Captured, Error
     * @throws VariableNotContainsException
     */
    public function __construct(string $paymentId, string $status)
    {
        Utils::CheckValueContains($status, 'status', PaymentInfoResponse::Statuses);
        $this->paymentId = $paymentId;
        $this->status = $status;
    }

    /**
     * Returns paymentId of notify response
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    /**
     *  Returns status in string of notify response
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }


    /**
     * Create PaymentNotifyData object from response array.
     * @param array $responseArray
     * @return self
     * @throws Exception
     */
    public static function fromArray(array $responseArray): self
    {
        if (!array_key_exists('status', $responseArray)) {
            throw new Exception('Array key \"Status\" missing in payment notify data!');
        }
        if (!array_key_exists('paymentId', $responseArray)) {
            throw new Exception('Array key \"PaymentId\" missing in payment notify data!');
        }
        if (gettype($responseArray['status']) !== 'string') {
            throw new Exception('Array key \"status\" type does not match string type in payment notify!');
        }
        if (gettype($responseArray['paymentId']) !== 'string') {
            throw new Exception('Array key \"paymentId\" type does not match string type in payment notify!');
        }

        return new PaymentNotifyData($responseArray['paymentId'], $responseArray['status']);
    }
}