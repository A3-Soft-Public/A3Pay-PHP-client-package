<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

use A3Soft\A3PayPhpClient\Helper\Util\AbstractToArray;

final class PaymentRequest extends AbstractToArray implements PaymentGatewayRequest
{
    private string $methodId;
    private string $merchantPaymentId;
    private string $currency;
    private string $amount;
    private string $orderNo;
    private Basket $basket;
    private string $redirectUrl;
    private ?string $language;
    private DanubePay $danubePay;

    /**
     * @param string $methodId Method GUID.
     * @param string $merchantPaymentId Merchant payment ID.
     * @param string $currency Currency in which purchase amount is expressed.<br>
     * The value is limited to 3 numeric characters and is represented by the ISO 4217 three-digit currency code, except 955-964 and 999 with currency exponent set to “2” by default.
     * @param string $amount The amount of funds requested in the currency of the source location of the transaction. Decimalization of the amount is implied by the value in the currency data element
     * @param string $orderNo Order number.
     * @param Basket $basket Customer basket data.
     * @param string $redirectUrl Redirect Url. Min. length 16.
     * @param DanubePay $danubePay DanubePay data.
     * @param string|null $language Used language.
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

    public function getMethodId(): string
    {
        return $this->methodId;
    }

    public function getMerchantPaymentId(): string
    {
        return $this->merchantPaymentId;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getOrderNo(): string
    {
        return $this->orderNo;
    }

    public function getBasket(): Basket
    {
        return $this->basket;
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getDanubePay(): DanubePay
    {
        return $this->danubePay;
    }
}