<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Helper\Util\AbstractToArray;

final class CustomerBasket extends AbstractToArray
{
    private ?string $customerNumber;
    private ?string $cardNumber;
    private ?string $externalUId;

    /**
     * @param string|null $customerNumber Customer number.
     * @param string|null $cardNumber Customer card number.
     * @param string|null $externalUId Customer external ID (from external SW).
     */
    public function __construct(
        ?string $customerNumber = null,
        ?string $cardNumber = null,
        ?string $externalUId = null
    )
    {
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