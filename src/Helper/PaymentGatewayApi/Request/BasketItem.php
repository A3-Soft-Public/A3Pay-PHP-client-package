<?php

namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;

/**
 * BasketItem represents data model of BasketItem
 * @package DataModel
 */
final class BasketItem extends AbstractToArray
{
    /** @var string[] available measure units for measureUnit property */
    const MeasureUnits = [
        'Ks' => 'Ks',
        'L' => 'L',
        'Ml' => 'Ml',
        'Pár' => 'Pár',
        'G' => 'G',
        'Kg' => 'Kg',
        'Cm' => 'Cm',
        'M' => 'M',
        'Hod' => 'Hod',
        'Hl' => 'Hl',
        'Bal' => 'Bal',
        'T' => 'T',
        'M2' => 'M2',
        'M3' => 'M3',
        'Dcl' => 'Dcl',
    ];



    /**
     * @var string Item name.
     */
    private string $name;
    /**
     * @var float Item VAT rate.
     */
    private float $vatRate;
    /**
     * @var float Item quantity.
     */
    private float $quantity;
    /**
     * @var string Item measure unit.<br>Available values :
     *  Ks, L, Ml, Pár, G, Kg, Cm, M,<br>
     *  Hod, Hl, Bal, T, M2, M3, Dcl
     */
    private string $measureUnit;
    /**
     * @var float Item original price (before discounts, etc.)
     */
    private float $originalUnitPrice;
    /**
     * @var float Item unit price.
     */
    private float $unitPrice;
    /**
     * @var float Item price total (unit price * quantity)
     */
    private float $priceTotal;
    /**
     * @var float Item price VAT base total (tax base).
     */
    private float $priceVatBaseTotal;
    /**
     * @var float Item price VAT total value (difference between total price and tax base)
     */
    private float $priceVatTotal;
    /**
     * @var float Item rounding value.
     */
    private float $itemRounding;
    /**
     * @var string|null Item number.
     */
    private ?string $article;
    /**
     * @var string|null Item characteristic no. 1 (size, color, etc.)
     */
    private ?string $chr1;
    /**
     * @var string|null Item characteristic no. 2 (size, color, etc.)
     */
    private ?string $chr2;
    /**
     * @var string|null Item barcode (EAN).
     */
    private ?string $ean;
    /**
     * @var string|null Item external ID (from external SW) max 50 chars.
     */
    private ?string $externalUId;
    /**
     * @var string|null Optional text no. 1.
     */
    private ?string $text1;
    /**
     * @var string|null Optional long text no. 1. max. 256chars
     */
    private ?string $text1Long;

    /**
     * @param string $name Item name.
     * @param float $vatRate Item VAT rate.
     * @param float $quantity Item quantity.
     * @param string $measureUnit Item measure unit.<br>Available values :
     * Ks, L, Ml, Pár, G, Kg, Cm, M,<br>
     * Hod, Hl, Bal, T, M2, M3, Dcl
     * @param float $originalUnitPrice Item original price (before discounts, etc.)
     * @param float $unitPrice Item unit price.
     * @param float $priceTotal Item price total (unit price * quantity)
     * @param float $priceVatBaseTotal Item price VAT base total (tax base).
     * @param float $priceVatTotal Item price VAT total value (difference between total price and tax base)
     * @param float $itemRounding Item rounding value.
     * @param string|null $article Item number.
     * @param string|null $chr1 Item characteristic no. 1 (size, color, etc.)
     * @param string|null $chr2 Item characteristic no. 2 (size, color, etc.)
     * @param string|null $ean Item barcode (EAN).
     * @param string|null $text1 Optional text no. 1.
     * @param string|null $text1Long Optional long text no. 1.
     * @param string|null $externalUId Item external ID (from external SW).
     * @throws VariableLengthException|\InvalidArgumentException
     */
    public function __construct(
        string $name,
        float $vatRate,
        float $quantity,
        string $measureUnit,
        float $originalUnitPrice,
        float $unitPrice,
        float $priceTotal,
        float $priceVatBaseTotal,
        float $priceVatTotal,
        float $itemRounding,
        ?string $article = null,
        ?string $chr1 = null,
        ?string $chr2 = null,
        ?string $ean = null,
        ?string $externalUId = null,
        ?string $text1 = null,
        ?string $text1Long = null
    )
    {
        if(!in_array($measureUnit, self::MeasureUnits))
            throw new \InvalidArgumentException("The field \"measureUnit\" is not in acceptable values -> BasketItem::MeasureUnits");
        Utils::ClearAndTruncateVariableLen($name, 'name', 128);

        Utils::ClearAndTruncateVariableLen($article, 'article', 14, true);
        Utils::ClearAndTruncateVariableLen($chr1, 'chr1', 20, true);
        Utils::ClearAndTruncateVariableLen($chr2, 'chr2', 20, true);
        Utils::ClearAndTruncateVariableLen($ean, 'ean', 20, true);
        Utils::ClearAndTruncateVariableLen($externalUId, 'externalUId', 50, true);
        Utils::ClearAndTruncateVariableLen($text1, 'text1', 256, true);
        $text1Long = Utils::ClearText($text1Long);

        $this->name = $name;
        $this->vatRate = $vatRate;
        $this->quantity = $quantity;
        $this->measureUnit = $measureUnit;
        $this->originalUnitPrice = $originalUnitPrice;
        $this->unitPrice = $unitPrice;
        $this->priceTotal = $priceTotal;
        $this->priceVatBaseTotal = $priceVatBaseTotal;
        $this->priceVatTotal = $priceVatTotal;
        $this->itemRounding = $itemRounding;
        $this->article = $article;
        $this->chr1 = $chr1;
        $this->chr2 = $chr2;
        $this->ean = $ean;
        $this->text1 = $text1;
        $this->text1Long = $text1Long;
        $this->externalUId = $externalUId;
    }

    /**
     * returns name of basket item
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * returns vat rate of basket item
     * @return float
     */
    public function getVatRate(): float
    {
        return $this->vatRate;
    }

    /**
     * returns quantity of basket item
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * returns measure unit of basket item
     * @return string
     */
    public function getMeasureUnit(): string
    {
        return $this->measureUnit;
    }

    /**
     * returns original unit price before sale
     * @return float
     */
    public function getOriginalUnitPrice(): float
    {
        return $this->originalUnitPrice;
    }

    /**
     * returns current unit price
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    /**
     * returns total price of items (without vat)
     * @return float
     */
    public function getPriceTotal(): float
    {
        return $this->priceTotal;
    }

    /**
     * returns total vat of items
     * @return float
     */
    public function getPriceVatBaseTotal(): float
    {
        return $this->priceVatBaseTotal;
    }

    /**
     * returns total price of items (vat included)
     * @return float
     */
    public function getPriceVatTotal(): float
    {
        return $this->priceVatTotal;
    }

    /**
     * returns item rounding
     * @return float
     */
    public function getItemRounding(): float
    {
        return $this->itemRounding;
    }

    /**
     * returns article name
     * @return string|null
     */
    public function getArticle(): ?string
    {
        return $this->article;
    }

    /**
     * returns characteristics number 1, if any
     * @return string|null
     */
    public function getChr1(): ?string
    {
        return $this->chr1;
    }

    /**
     * returns characteristics number 2, if any
     * @return string|null
     */
    public function getChr2(): ?string
    {
        return $this->chr2;
    }

    /**
     * returns ean of item, if any
     * @return string|null
     */
    public function getEan(): ?string
    {
        return $this->ean;
    }

    /**
     * returns external uid if any
     * @return string|null
     */
    public function getExternalUId(): ?string
    {
        return $this->externalUId;
    }

    /**
     * returns short text, if any
     * @return string|null
     */
    public function getText1(): ?string
    {
        return $this->text1;
    }

    /**
     * returns long text if any
     * @return string|null
     */
    public function getText1Long(): ?string
    {
        return $this->text1Long;
    }

}