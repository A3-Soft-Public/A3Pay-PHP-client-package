<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Util\AbstractToArray;

/**
 * Basket represents data model for request Basket
 * @package DataModel
 */
final class Basket extends AbstractToArray
{
    /** @var BasketHeader basket header */
    private BasketHeader $header;
    /**
     * @var Payment[] list of Payment objects it will be suitable if order will want to be placed by more options.
     * For example part of price will be paid by voucher and rest by credit card.
     */
    private array $payments;
    /** @var CustomerBasket hold information about customer */
    private CustomerBasket $customer;
    /**
     * @var BasketItem[] hold list of basket item
     */
    private array $items;

    /**
     * @param BasketHeader $header basket header
     * @param list<Payment> $payments list of Payment objects
     * @param CustomerBasket $customerBasket information about customer
     * @param list<BasketItem> $basketItems information about basket items
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

    /**
     * returns basket header
     * @return BasketHeader
     */
    public function getHeader(): BasketHeader
    {
        return $this->header;
    }

    /**
     * returns list of payments
     * @return Payment[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * returns information about customer
     * @return CustomerBasket
     */
    public function getCustomer(): CustomerBasket
    {
        return $this->customer;
    }

    /**
     * returns basket items
     * @return BasketItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }



}