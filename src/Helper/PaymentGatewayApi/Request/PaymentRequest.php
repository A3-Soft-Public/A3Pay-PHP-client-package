<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableNotGuidException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;

/**
 * PaymentRequest represents data model of data needed for payment create request
 * @package DataModel
 */
final class PaymentRequest extends AbstractToArray implements PaymentGatewayRequest
{
    /** @var string Method GUID. */
    private string $methodId;
    /** @var string Merchant payment ID GUID. */
    private string $merchantPaymentId;
    /** @var string Currency in which purchase amount is expressed.<br>
     * The value is limited to 3 numeric characters and is represented by the ISO 4217 three-digit currency code, except 955-964 and 999 with currency exponent set to “2” by default.
     */
    private string $currency;
    /** @var string The amount of funds requested in the currency of the source location of the transaction. Decimalization of the amount is implied by the value in the currency data element */
    private string $amount;
    /** @var string Order number */
    private string $orderNo;
    /** @var Basket Customer basket data */
    private Basket $basket;
    /** @var string Redirect Url. Min. length 16 */
    private string $redirectUrl;
    /** @var string|null Used language */
    private ?string $language;
    /** @var DanubePay DanubePay data */
    private DanubePay $danubePay;

    /**
     * @param string $methodId Method GUID.
     * @param string $merchantPaymentId Merchant payment ID GUID.
     * @param string $currency Currency in which purchase amount is expressed.<br>
     * The value is limited to 3 numeric characters and is represented by the ISO 4217 three-digit currency code, except 955-964 and 999 with currency exponent set to “2” by default.
     * @param string $amount The amount of funds requested in the currency of the source location of the transaction. Decimalization of the amount is implied by the value in the currency data element
     * @param string $orderNo Order number.
     * @param Basket $basket Customer basket data.
     * @param string $redirectUrl Redirect Url. Min. length 16.
     * @param DanubePay $danubePay DanubePay data.
     * @param string|null $language Used language.
     * @throws VariableLengthException|VariableNotGuidException
     */
    public function __construct(
        string $methodId,
        string $merchantPaymentId,
        string $currency,
        string $amount,
        string $orderNo,
        Basket $basket,
        string $redirectUrl,
        DanubePay $danubePay,
        ?string $language = null
    )
    {
        Utils::checkValueGuid($methodId, 'methodId');
        Utils::checkValueGuid($merchantPaymentId, 'merchantPaymentId');
        Utils::checkVariableLen($currency, 'currency', 3);
        Utils::checkVariableLen($amount, 'amount', 12);
        Utils::checkVariableLen($orderNo, 'orderNo', 16);
        Utils::checkVariableLen($redirectUrl, 'redirectUrl', 1024);

        $this->methodId = $methodId;
        $this->merchantPaymentId = $merchantPaymentId;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->orderNo = $orderNo;
        $this->basket = $basket;
        $this->redirectUrl = $redirectUrl;
        $this->danubePay = $danubePay;
        $this->language = $language;
    }

    /**
     * returns method id
     * @return string
     */
    public function getMethodId(): string
    {
        return $this->methodId;
    }

    /**
     * returns merchant id of payment
     * @return string
     */
    public function getMerchantPaymentId(): string
    {
        return $this->merchantPaymentId;
    }

    /**
     * returns currency
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * returns amount
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * returns order number
     * @return string
     */
    public function getOrderNo(): string
    {
        return $this->orderNo;
    }

    /**
     * returns customer basket data
     * @return Basket
     */
    public function getBasket(): Basket
    {
        return $this->basket;
    }

    /**
     * returns redirect url
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * returns language
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * returns DanubePay data
     * @return DanubePay
     */
    public function getDanubePay(): DanubePay
    {
        return $this->danubePay;
    }
}