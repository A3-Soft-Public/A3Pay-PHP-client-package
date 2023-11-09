<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;

final class CustomerBasket extends AbstractToArray
{
    private ?string $customerNumber;
    private ?string $cardNumber;
    private ?string $externalUId;

    /**
     * @param string|null $customerNumber Customer number.
     * @param string|null $cardNumber Customer card number.
     * @param string|null $externalUId Customer external ID (from external SW).
     * @throws VariableLengthException
     */
    public function __construct(
        ?string $customerNumber = null,
        ?string $cardNumber = null,
        ?string $externalUId = null
    )
    {
        Utils::checkVariableLen($customerNumber, 'customerNumber', 20, true, 1);
        Utils::checkVariableLen($cardNumber, 'cardNumber', 32, true, 1);
        Utils::checkVariableLen($externalUId, 'externalUId', 40, true, 1);
        $this->customerNumber = $customerNumber;
        $this->cardNumber = $cardNumber;
        $this->externalUId = $externalUId;
    }

    public function getCustomerNumber(): ?string
    {
        return $this->customerNumber;
    }

    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    public function getExternalUId(): ?string
    {
        return $this->externalUId;
    }
}