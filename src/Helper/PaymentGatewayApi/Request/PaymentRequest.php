<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableNotContainsException;
use A3Soft\A3PayPhpClient\Exception\VariableNotGuidException;
use A3Soft\A3PayPhpClient\Exception\VariableNotInRangeException;
use A3Soft\A3PayPhpClient\Exception\VariableNotUrlException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;
/**
 * PaymentRequest represents data model of data needed for payment create request
 * @package DataModel
 */
final class PaymentRequest extends AbstractToArray implements PaymentGatewayRequest
{


    /** @var string Merchant payment ID GUID. */
    private string $merchantPaymentId;


    /** @var string The amount of funds requested in the currency of the source location of the transaction. Decimalization of the amount is implied by the value in the currency data element */
    private string $amount;

    /** @var string Order number */
    private string $orderNo;
    /** @var Basket Customer basket data */
    private Basket $basket;

    /** @var CardHolder Cardholder data. */
    private CardHolder $customer;

    /** @var string Redirect Url address for redirecting the
    customer after payment is completed.
    Min. length 16. */
    private string $redirectUrl;

    /** @var string|null Used language */
    private ?string $language;


    private ?string $paymentReferenceType;
    private ?int $emailTtl;
    private ?string $message;

    /**
     * @param string $merchantPaymentId Merchant payment ID.
     * @param string $amount The amount of funds requested in the currency of the source location of the transaction. Decimalization of the amount is implied by the value in the currency data element
     * @param string $orderNo Order number.
     * @param Basket $basket Customer basket data.
     * @param CardHolder $customer {@link CardHolder} data
     * @param string $redirectUrl Redirect Url address for redirecting the
     * customer after payment is completed.
     * Min. length 16.
     * @param string|null $language Used language.
     * @param string|null $paymentReferenceType
     * @param int|null $emailTtl
     * @param string|null $message
     * @throws VariableLengthException
     * @throws VariableNotContainsException
     * @throws VariableNotInRangeException
     * @throws VariableNotUrlException
     */
    public function __construct(
        string $merchantPaymentId,
        string $amount,
        string $orderNo,
        Basket $basket,
        CardHolder $customer,
        string $redirectUrl,
        ?string $language = null,
        ?string $paymentReferenceType = PaymentReferenceType::Direct,
        ?int $emailTtl = null,
        ?string $message = null
    )
    {

        Utils::checkVariableLen($merchantPaymentId, 'merchantPaymentId', 36);
        Utils::checkVariableLen($amount, 'amount', 12);
        Utils::checkVariableLen($orderNo, 'orderNo', 16);
        Utils::checkValueUrl($redirectUrl, 'redirectUrl', 16, 1024);

        Utils::checkVariableLen($language, 'language', 36, true);


        if ($paymentReferenceType !== null) {
            switch ($paymentReferenceType) {
                case PaymentReferenceType::Direct:
                case PaymentReferenceType::Email:
                case PaymentReferenceType::Test:
                {
                    break;
                }
                default: throw new VariableNotContainsException($paymentReferenceType, 'paymentReferenceType', [PaymentReferenceType::Direct, PaymentReferenceType::Email, PaymentReferenceType::Test]);

            }
        }

        /** if emailTtl is not null and is bigger than 31 days in seconds ... */
        if ($emailTtl !== null && $emailTtl > 2678400) {
            throw new VariableNotInRangeException($emailTtl, 'emailTtl', null, 2678400);
        }

        Utils::checkVariableLen($message, 'message', 128, true);

        $this->merchantPaymentId = $merchantPaymentId;
        $this->amount = $amount;
        $this->orderNo = $orderNo;
        $this->basket = $basket;
        $this->language = $language;
        $this->customer = $customer;
        $this->redirectUrl = $redirectUrl;
        $this->paymentReferenceType = $paymentReferenceType;
        $this->emailTtl = $emailTtl;
        $this->message = $message;
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

    public function getCustomer(): CardHolder
    {
        return $this->customer;
    }

    public function getPaymentReferenceType(): ?string
    {
        return $this->paymentReferenceType;
    }

    public function getEmailTtl(): ?int
    {
        return $this->emailTtl;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }




}