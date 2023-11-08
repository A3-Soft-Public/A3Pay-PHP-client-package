<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

use A3Soft\A3PayPhpClient\Helper\Util\AbstractToArray;

final class DanubePay extends AbstractToArray
{

    /**
     * @var string Registered Terminal ID (TID) based on provided TID range.<br>
     * It is mandatory to first register the terminalId for e-commerce and only then request payments.
     */
    private string $terminalId;
    /**
     * @var CardHolder CardHolder data.
     */
    private CardHolder $customer;


    /**
     * @param string $terminalId Registered Terminal ID (TID) based on provided TID range.<br>
     *  It is mandatory to first register the terminalId for e-commerce and only then request payments.
     * @param CardHolder $customer CardHolder data.
     */
    public function __construct(
        string $terminalId,
        CardHolder $customer
    )
    {
        $this->terminalId = $terminalId;
        $this->customer = $customer;
    }

    public function getTerminalId(): string
    {
        return $this->terminalId;
    }

    public function getCustomer(): CardHolder
    {
        return $this->customer;
    }




}