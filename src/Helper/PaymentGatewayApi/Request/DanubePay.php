<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;

/**
 * DanubePay data model, that contains information about DanubePay request data
 * @package DataModel
 */

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
     * @throws VariableLengthException
     */
    public function __construct(
        string $terminalId,
        CardHolder $customer
    )
    {
        Utils::checkVariableLen($terminalId, 'terminalId', 8);
        $this->terminalId = $terminalId;
        $this->customer = $customer;
    }

    /**
     * returns terminalId
     * @return string
     */
    public function getTerminalId(): string
    {
        return $this->terminalId;
    }

    /**
     * returns customer CardHolder object
     * @return CardHolder
     */
    public function getCustomer(): CardHolder
    {
        return $this->customer;
    }

}