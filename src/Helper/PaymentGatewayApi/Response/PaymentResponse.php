<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response;

use Exception;

/**
 * PaymentResponse represents data model of create payment response
 * @package DataModel
 */
final class PaymentResponse extends \A3Soft\A3PayPhpClient\Util\AbstractToArray
{
    private string $paymentId;
    private string $redirectUrl;

    /**
     * @param string $paymentId Payment ID.
     * @param string $redirectUrl Redirect URL.
     */
    public function __construct(
        string $paymentId,
        string $redirectUrl
    )
    {
        $this->paymentId = $paymentId;
        $this->redirectUrl = $redirectUrl;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * Create PaymentResponse from array
     * @param array $responseArray
     * @return PaymentResponse
     * @throws Exception
     */
    public static function fromArray(array $responseArray): PaymentResponse
    {
        if (!array_key_exists('paymentId', $responseArray)) {
            throw new Exception('Array key \"paymentId\" missing in response data!');
        }
        if (!array_key_exists('redirectUrl', $responseArray)) {
            throw new Exception('Array key \"redirectUrl\" missing in response data!');
        }
        if (gettype($responseArray['paymentId']) !== 'string') {
            throw new Exception('Array key \"paymentId\" type does not match string type!');
        }
        if (gettype($responseArray['redirectUrl']) !== 'string') {
            throw new Exception('Array key \"redirectUrl\" type does not match string type!');
        }
        return new PaymentResponse($responseArray['paymentId'], $responseArray['redirectUrl']);
    }

}