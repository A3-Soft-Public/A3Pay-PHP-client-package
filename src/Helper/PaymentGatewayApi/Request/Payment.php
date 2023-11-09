<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableNotContainsException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;

final class Payment extends AbstractToArray
{

    const PaymentIdCash = 1;
    const PaymentIdCard = 2;
    const PaymentIdVoucher = 3;


    private int $paymentId;
    private float $value;
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
        Utils::checkValueContainsArgs($paymentId, 'paymentId', self::PaymentIdCash, self::PaymentIdCard, self::PaymentIdVoucher);
        Utils::checkVariableLen($description, 'description', 42, true);
        $this->paymentId = $paymentId;
        $this->value = $value;
        $this->description = $description;
    }

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}