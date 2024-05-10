<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableNotContainsException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;

/**
 * CardHolder represents data model of customer
 * @package DataModel
 */
final class CardHolder extends AbstractToArray
{
    /** @var string Name of the Cardholder. */
    private string $cardHolderName;

    /** @var string The email address associated with the
     * account that is either entered by the
     * Cardholder, or is on file with the 3DS
     * Requestor. This field shall meet
     * requirements of Section 3.4 of IETF RFC
     * 5322. */
    private string $email;

    /** @var string|null First line of the street address or
    equivalent local portion of the Cardholder
    billing address associated with the card
    used for this purchase. This field is
    optional, but recommended to include. */
    private ?string $billAddrLine1;

    /** @var string|null ZIP or other postal code of the Cardholder
    billing address associated with the card
    used for this purchase. This field is
    optional, but recommended to include. */
    private ?string $billAddrPostCode;

    /** @var string|null The city of the Cardholder billing address
     * associated with the card used for this
     * purchase. This field is optional, but
     * recommended to include. */
    private ?string $billAddrCity;

    /** @var string|null The state or province of the Cardholder
    billing address associated with the card
    used for this purchase.
    The value should be the country
    subdivision code defined in ISO 3166-2.
    This field is optional, but recommended
    to include. */
    private ?string $billAddrState;

    /** @var string|null The country of the Cardholder billing
    address associated with the card used for
    this purchase.
    This value shall be the ISO 3166-1
    numeric country code, except values from
    range 901 - 999 which are reserved by
    ISO. This field is optional, but
    recommended to include. */
    private ?string $billAddrCountry;

    /** @var string|null First line of the street address or
     * equivalent local portion of the shipping
     * address associated with the card used for
     * this purchase. This field is optional, but
     * recommended to include. */
    private ?string $shipAddrLine1;

    /** @var string|null ZIP or other postal code of the shipping
    address associated with the card used for
    this purchase. This field is optional, but
    recommended to include. */
    private ?string $shipAddrPostCode;

    /** @var string|null City portion of the shipping address
    requested by the Cardholder.
    This field is required unless shipping
    information is the same as billing
    information. This field is optional, but
    recommended to include. */
    private ?string $shipAddrCity;

    /** @var string|null The state or province of the shipping
    address associated with the card used for
    this purchase. */
    private ?string $shipAddrState;

    /** @var string|null Country of the shipping address requested
    by the Cardholder. This value shall be the ISO 3166-1
    numeric country code, except values from
    range 901 - 999 which are reserved by
    ISO.
    This field is required if Cardholder
    Shipping Address State is present and if
    shipping information is not the same as
    billing information. This field is optional,
    but recommended to include. */
    private ?string $shipAddrCountry;

    /** @var CardHolderPhoneNumber|null The mobile phone provided by the
    cardholder. CardHolderPhoneNumber */
    private ?CardHolderPhoneNumber $mobilePhone;

    /** @var CardHolderPhoneNumber|null The home phone provided by the
    cardholder. CardHolderPhoneNumber */
    private ?CardHolderPhoneNumber $homePhone;

    /** @var CardHolderPhoneNumber|null The work phone provided by the
    cardholder. CardHolderPhoneNumber */
    private ?CardHolderPhoneNumber $workPhone;

    /** @var string|null Second line of the street address or
    equivalent local portion of the Cardholder
    billing address associated with the card
    used for this purchase. */
    private ?string $billAddrLine2;

    /** @var string|null Third line of the street address or
    equivalent local portion of the Cardholder
    billing address associated with the card
    used for this purchase. */
    private ?string $billAddrLine3;

    /** @var string|null Second line of the street address or
    equivalent local portion of the shipping
    address associated with the card used for
    this purchase. */
    private ?string $shipAddrLine2;

    /** @var string|null Third line of the street address or
    equivalent local portion of the shipping
    address associated with the card used for
    this purchase. */
    private ?string $shipAddrLine3;

    /**
     * @param string $cardHolderName Name of the Cardholder.
     * @param string $email The email address associated with the
     * account that is either entered by the
     * Cardholder, or is on file with the 3DS Requestor.
     * This field shall meet
     * requirements of Section 3.4 of IETF RFC
     * 5322.
     * @param CardHolderPhoneNumber|null $mobilePhone The mobile phone provided by the
     * cardholder.
     * @param CardHolderPhoneNumber|null $homePhone The home phone provided by the
     * cardholder.
     * @param CardHolderPhoneNumber|null $workPhone The work phone provided by the
     * cardholder.
     * @param string|null $billAddrLine1 First line of the street address or
     * equivalent local portion of the Cardholder
     * billing address associated with the card
     * used for this purchase. This field is
     * optional, but recommended to include.
     * @param string|null $billAddrLine2 Second line of the street address or
     * equivalent local portion of the Cardholder
     * billing address associated with the card
     * used for this purchase.
     * @param string|null $billAddrLine3 Third line of the street address or
     * equivalent local portion of the Cardholder
     * billing address associated with the card
     * used for this purchase.
     * @param string|null $billAddrPostCode ZIP or other postal code of the Cardholder
     * billing address associated with the card
     * used for this purchase. This field is
     * optional, but recommended to include.
     * @param string|null $billAddrCity The city of the Cardholder billing address
     * associated with the card used for this
     * purchase. This field is optional, but
     * recommended to include.
     * @param string|null $billAddrState The state or province of the Cardholder
     * billing address associated with the card
     * used for this purchase.
     * The value should be the country
     * subdivision code defined in ISO 3166-2.
     * This field is optional, but recommended
     * to include.
     * @param string|null $billAddrCountry The country of the Cardholder billing
     * address associated with the card used for
     * this purchase.
     * This value shall be the ISO 3166-1
     * numeric country code, except values from
     * range 901 - 999 which are reserved by
     * ISO. This field is optional, but
     * recommended to include.
     * @param string|null $shipAddrLine1 First line of the street address or
     * equivalent local portion of the shipping
     * address associated with the card used for
     * this purchase. This field is optional, but
     * recommended to include.
     * @param string|null $shipAddrLine2 Second line of the street address or
     * equivalent local portion of the shipping
     * address associated with the card used for
     * this purchase.
     * @param string|null $shipAddrLine3 Third line of the street address or
     * equivalent local portion of the shipping
     * address associated with the card used for
     * this purchase.
     * @param string|null $shipAddrPostCode ZIP or other postal code of the shipping
     * address associated with the card used for
     * this purchase. This field is optional, but
     * recommended to include.
     * @param string|null $shipAddrCity City portion of the shipping address
     * requested by the Cardholder.
     * This field is required unless shipping
     * information is the same as billing
     * information. This field is optional, but
     * recommended to include.
     * @param string|null $shipAddrCountry The state or province of the shipping
     * address associated with the card used for
     * this purchase.
     * @param string|null $shipAddrState Country of the shipping address requested
     * by the Cardholder.
     * This value shall be the ISO 3166-1
     * numeric country code, except values from
     * range 901 - 999 which are reserved by
     * ISO.
     * This field is required if Cardholder
     * Shipping Address State is present and if
     * shipping information is not the same as
     * billing information. This field is optional,
     * but recommended to include.
     * @throws VariableLengthException
     */
  public function __construct(
      string $cardHolderName,
      string $email,
      ?CardHolderPhoneNumber $mobilePhone = null,
      ?CardHolderPhoneNumber $homePhone = null,
      ?CardHolderPhoneNumber $workPhone = null,
      ?string $billAddrLine1 = null,
      ?string $billAddrLine2 = null,
      ?string $billAddrLine3 = null,
      ?string $billAddrPostCode = null,
      ?string $billAddrCity = null,
      ?string $billAddrState = null,
      ?string $billAddrCountry = null,
      ?string $shipAddrLine1 = null,
      ?string $shipAddrLine2 = null,
      ?string $shipAddrLine3 = null,
      ?string $shipAddrPostCode = null,
      ?string $shipAddrCity = null,
      ?string $shipAddrCountry = null,
      ?string $shipAddrState = null
  )
  {
      Utils::checkVariableLen($cardHolderName, 'cardHolderName', 50);
      Utils::checkVariableLen($email, 'email', 256);


      Utils::checkVariableLen($billAddrLine1, 'billAddrLine1', 50, true);
      Utils::checkVariableLen($billAddrLine2, 'billAddrLine2', 50, true);
      Utils::checkVariableLen($billAddrLine3, 'billAddrLine3', 50, true);
      Utils::checkVariableLen($billAddrPostCode, 'billAddrPostCode', 16, true);
      Utils::checkVariableLen($billAddrCity, 'billAddrCity', 50, true);
      Utils::checkVariableLen($billAddrState, 'billAddrState', 3, true);
      Utils::checkVariableLen($billAddrCountry, 'billAddrCountry', 3, true);


      Utils::checkVariableLen($shipAddrLine1, 'shipAddrLine1', 50, true);
      Utils::checkVariableLen($shipAddrLine2, 'shipAddrLine2', 50, true);
      Utils::checkVariableLen($shipAddrLine3, 'shipAddrLine3', 50, true);
      Utils::checkVariableLen($shipAddrPostCode, 'shipAddrPostCode', 16, true);
      Utils::checkVariableLen($shipAddrCity, 'shipAddrCity', 50, true);
      Utils::checkVariableLen($shipAddrState, 'shipAddrState', 3, true);
      Utils::checkVariableLen($shipAddrCountry, 'shipAddrCountry', 3, true);

      $this->cardHolderName = $cardHolderName;
      $this->billAddrLine1 = $billAddrLine1;
      $this->billAddrPostCode = $billAddrPostCode;
      $this->billAddrCity = $billAddrCity;
      $this->billAddrState = $billAddrState;
      $this->billAddrCountry = $billAddrCountry;
      $this->email = $email;
      $this->shipAddrLine1 = $shipAddrLine1;
      $this->shipAddrPostCode = $shipAddrPostCode;
      $this->shipAddrCity = $shipAddrCity;
      $this->shipAddrState = $shipAddrState;
      $this->shipAddrCountry = $shipAddrCountry;
      $this->mobilePhone = $mobilePhone;
      $this->homePhone = $homePhone;
      $this->workPhone = $workPhone;
      $this->billAddrLine2 = $billAddrLine2;
      $this->billAddrLine3 = $billAddrLine3;
      $this->shipAddrLine2 = $shipAddrLine2;
      $this->shipAddrLine3 = $shipAddrLine3;
  }

    /**
     * returns customer/cardholder name
     * @return string
     */
    public function getCardHolderName(): string
    {
        return $this->cardHolderName;
    }

    /**
     * returns bill address line 1
     * @return string
     */
    public function getBillAddrLine1(): string
    {
        return $this->billAddrLine1;
    }

    /**
     * returns bill address postcode
     * @return string
     */
    public function getBillAddrPostCode(): string
    {
        return $this->billAddrPostCode;
    }

    /**
     * returns bill address city
     * @return string
     */
    public function getBillAddrCity(): string
    {
        return $this->billAddrCity;
    }

    /**
     * returns bill address state by ISO 3166-2
     * @return string
     */
    public function getBillAddrState(): string
    {
        return $this->billAddrState;
    }

    /**
     * returns bill address country by ISO 3166-1 numeric code
     * @return string
     */
    public function getBillAddrCountry(): string
    {
        return $this->billAddrCountry;
    }

    /**
     * returns customer email
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * returns ship address line 1
     * @return string
     */
    public function getShipAddrLine1(): string
    {
        return $this->shipAddrLine1;
    }

    /**
     * returns ship address postcode
     * @return string
     */
    public function getShipAddrPostCode(): string
    {
        return $this->shipAddrPostCode;
    }

    /**
     * returns ship address city
     * @return string
     */
    public function getShipAddrCity(): string
    {
        return $this->shipAddrCity;
    }

    /**
     * returns ship address state by ISO 3166-2
     * @return string
     */
    public function getShipAddrState(): string
    {
        return $this->shipAddrState;
    }

    /**
     * returns ship address country by ISO 3166-1 numeric code
     * @return string
     */
    public function getShipAddrCountry(): string
    {
        return $this->shipAddrCountry;
    }

    /**
     * returns mobile phone number object, if any
     * @return CardHolderPhoneNumber|null
     */
    public function getMobilePhone(): ?CardHolderPhoneNumber
    {
        return $this->mobilePhone;
    }

    /**
     * returns home phone number object, if any
     * @return CardHolderPhoneNumber|null
     */
    public function getHomePhone(): ?CardHolderPhoneNumber
    {
        return $this->homePhone;
    }

    /**
     * returns work phone number object, if any
     * @return CardHolderPhoneNumber|null
     */
    public function getWorkPhone(): ?CardHolderPhoneNumber
    {
        return $this->workPhone;
    }

    /**
     * returns bill address line 2, if any
     * @return string|null
     */
    public function getBillAddrLine2(): ?string
    {
        return $this->billAddrLine2;
    }

    /**
     * returns bill address line 3, if any
     * @return string|null
     */
    public function getBillAddrLine3(): ?string
    {
        return $this->billAddrLine3;
    }

    /**
     * returns ship address line 2, if any
     * @return string|null
     */
    public function getShipAddrLine2(): ?string
    {
        return $this->shipAddrLine2;
    }

    /**
     * returns ship address line 3, if any
     * @return string|null
     */
    public function getShipAddrLine3(): ?string
    {
        return $this->shipAddrLine3;
    }

}