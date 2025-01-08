<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableNotContainsException;
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


    /** @var string The amount of funds requested in the
    currency of the source location of the
    transaction.
    Decimalization of the amount is implied
    by the value in the currency data element.
    The amount is shown in the smallest
    currency units - 1,50 is presented as 150. */
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

    /** @var int|null Ttl for paymentTypeemail in sec.
    Max value is 31 days. */
    private ?int $emailTtl;

    /** @var string|null Custom message for client. */
    private ?string $message;

    /** @var string|null ApiRequester identifier (max length 100). */
    private ?string $pluginDetail;

    /**
     * @param string $merchantPaymentId Merchant payment ID.
     * @param string $amount The amount of funds requested in the
     * currency of the source location of the
     * transaction.
     * Decimalization of the amount is implied
     * by the value in the currency data element.
     * The amount is shown in the smallest
     * currency units - 1,50 is presented as 150.
     * @param string $orderNo Order number.
     * @param Basket $basket Customer basket data.
     * @param CardHolder $customer {@link CardHolder} data
     * @param string $redirectUrl Redirect Url address for redirecting the
     * customer after payment is completed.
     * Min. length 16.
     * @param string|null $language Used language.
     * @param string|null $paymentReferenceType PaymentReferenceType
     * Available values:
     * Direct - default, direct link to payment
     * Email - deferred link
     * Test - test the payment and validity. Payment will not be deposited.
     * @param int|null $emailTtl Ttl for paymentType email in sec.
     * Max value is 31 days.
     * @param string|null $message Custom message for client.
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
        ?string $message = null,
        ?string $pluginDetail = null
    )
    {

        Utils::CheckVariableLen($merchantPaymentId, 'merchantPaymentId', 36);
        Utils::CheckVariableLen($amount, 'amount', 12);
        Utils::CheckVariableLen($orderNo, 'orderNo', 16);
        Utils::CheckValueUrl($redirectUrl, 'redirectUrl', 16, 1024);

        Utils::CheckVariableLen($language, 'language', 36, true);
        Utils::ClearAndTruncateVariableLen($pluginDetail, 'pluginDetail', 100, true);

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

        Utils::CheckVariableLen($message, 'message', 128, true);

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
        $this->pluginDetail = $pluginDetail;
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

    public function getPluginDetail(): ?string
    {
        return $this->pluginDetail;
    }






}