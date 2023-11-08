<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Helper\Util\AbstractToArray;

final class Basket extends AbstractToArray
{
    private BasketHeader $header;
    /**
     * @var Payment[]
     */
    private array $payments;
    private CustomerBasket $customer;
    /**
     * @var BasketItem[]
     */
    private array $items;

    /**
     * @param BasketHeader $header
     * @param list<Payment> $payments
     * @param CustomerBasket $customerBasket
     * @param list<BasketItem> $basketItems
     */
    public function __construct(
        BasketHeader $header,
        array $payments,
        CustomerBasket $customerBasket,
        array $basketItems
    )
    {
        $this->header = $header;
        $this->payments = $payments;
        $this->customer = $customerBasket;
        $this->items = $basketItems;
    }

    public function getHeader(): BasketHeader
    {
        return $this->header;
    }

    public function getPayments(): array
    {
        return $this->payments;
    }

    public function getCustomer(): CustomerBasket
    {
        return $this->customer;
    }

    public function getItems(): array
    {
        return $this->items;
    }



}