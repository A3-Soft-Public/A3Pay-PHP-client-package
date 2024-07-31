<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableNotContainsException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;


/**
 * Payment represents data model for payment
 * @package DataModel
 */
final class Payment extends AbstractToArray
{
    /** @var int paymentId of cash */
    const PaymentIdCash = 1;
    /** @var int paymentId of bank card */
    const PaymentIdCard = 2;
    /** @var int paymentId of voucher */
    const PaymentIdVoucher = 3;

    /** @var int $paymentId id of payment method. available 1 - for cash, 2 - for bank card, 3 - for voucher */
    private int $paymentId;
    /** @var float $value value of payment */
    private float $value;
    /** @var string $description of payment */
    private string $description;

    /**
     * @param int $paymentId Payment identifier<br>
     * 1= cash (Cannot be used in this API)<br>
     * 2= card payment<br>
     * 3= voucher (Probably will be used in the future)
     * @param float $value Payment value.
     * @param string $description Payment description.
     * @throws VariableNotContainsException
     * @throws VariableLengthException
     */
    public function __construct(
        int $paymentId,
        float $value,
        string $description = ''
    )
    {
        Utils::CheckValueContainsArgs($paymentId, 'paymentId', self::PaymentIdCash, self::PaymentIdCard, self::PaymentIdVoucher);
        Utils::ClearAndTruncateVariableLen($description, 'description', 42, true);
        $this->paymentId = $paymentId;
        $this->value = $value;
        $this->description = $description;
    }

    /**
     * returns payment id
     * @return int
     */
    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    /**
     * returns value of payment
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * returns payment description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}