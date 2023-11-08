<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Helper\Util\AbstractToArray;

final class BasketHeader extends AbstractToArray
{
    private string $documentNumber;
    private ?string $reference;
    private ?float $rounding;
    private ?string $text1;
    private ?string $text2;
    private ?string $text3;

    /**
     * @param string $documentNumber Document number.
     * @param string|null $reference Reference variable symbol. Available string format a-zA-Z0-9
     * @param float|null $rounding Document rounding value.
     * @param string|null $text1 Optional text no. 1
     * @param string|null $text2 Optional text no. 2
     * @param string|null $text3 Optional text no. 3
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
        $this->documentNumber = $documentNumber;
        $this->reference = $reference;
        $this->rounding = $rounding;
        $this->text1 = $text1;
        $this->text2 = $text2;
        $this->text3 = $text3;
    }

    public function getDocumentNumber(): string
    {
        return $this->documentNumber;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function getRounding(): ?float
    {
        return $this->rounding;
    }

    public function getText1(): ?string
    {
        return $this->text1;
    }

    public function getText2(): ?string
    {
        return $this->text2;
    }

    public function getText3(): ?string
    {
        return $this->text3;
    }
}