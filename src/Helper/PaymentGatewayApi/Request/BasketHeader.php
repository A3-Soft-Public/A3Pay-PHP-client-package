<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;

/**
 * BasketHeader represents data model for basket header
 * @package DataModel
 */
final class BasketHeader extends AbstractToArray
{
    /** @var string Document number */
    private string $documentNumber;
    /** @var string|null Reference variable symbol. Available string format a-zA-Z0-9 */
    private ?string $reference;
    /** @var float|null Document rounding value */
    private ?float $rounding;
    /** @var string|null Optional text no. 1 */
    private ?string $text1;
    /** @var string|null Optional text no. 2 */
    private ?string $text2;
    /** @var string|null Optional text no. 3 */
    private ?string $text3;

    /**
     * If fields does not match requirements provided in integration manual, VariableLengthException whill be thrown
     * @param string $documentNumber Document number.
     * @param string|null $reference Reference variable symbol. Available string format a-zA-Z0-9
     * @param float|null $rounding Document rounding value.
     * @param string|null $text1 Optional text no. 1
     * @param string|null $text2 Optional text no. 2
     * @param string|null $text3 Optional text no. 3
     * @throws VariableLengthException
     */
    public function __construct(
        string $documentNumber,
        ?string $reference = null,
        ?float $rounding = null,
        ?string $text1 = null,
        ?string $text2 = null,
        ?string $text3 = null
    )
    {
        Utils::checkVariableLen($documentNumber, 'documentNumber', 20);
        Utils::checkVariableLen($reference, 'reference', 10, true);
        Utils::checkVariableLen($text1, 'text1', 200, true);
        Utils::checkVariableLen($text2, 'text2', 200, true);
        Utils::checkVariableLen($text3, 'text3', 200, true);

        $this->documentNumber = $documentNumber;
        $this->reference = $reference;
        $this->rounding = $rounding;
        $this->text1 = $text1;
        $this->text2 = $text2;
        $this->text3 = $text3;
    }

    /**
     * returns document number
     * @return string
     */
    public function getDocumentNumber(): string
    {
        return $this->documentNumber;
    }

    /**
     * returns order reference
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * returns order rounding
     * @return float|null
     */
    public function getRounding(): ?float
    {
        return $this->rounding;
    }

    /**
     * returns optional text num. 1
     * @return string|null
     */
    public function getText1(): ?string
    {
        return $this->text1;
    }

    /**
     * returns optional text num. 2
     * @return string|null
     */
    public function getText2(): ?string
    {
        return $this->text2;
    }

    /**
     * returns optional text num. 3
     * @return string|null
     */
    public function getText3(): ?string
    {
        return $this->text3;
    }
}