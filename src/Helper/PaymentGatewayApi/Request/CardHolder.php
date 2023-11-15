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
    /** @var string name of customer */
    private string $cardHolderName;
    /** @var string bill address street with number */
    private string $billAddrLine1;
    /** @var string bill address postcode */
    private string $billAddrPostCode;
    /** @var string bill address city */
    private string $billAddrCity;
    /** @var string bill address state by ISO 3166-2 */
    private string $billAddrState;
    /** @var string bill address country by ISO 3166-1 3-digit numeric code */
    private string $billAddrCountry;
    /** @var string email address of customer */
    private string $email;
    /** @var string ship address street with number */
    private string $shipAddrLine1;
    /** @var string  ship address postcode*/
    private string $shipAddrPostCode;
    /** @var string ship address city */
    private string $shipAddrCity;
    /** @var string ship address state by ISO 3166-2 */
    private string $shipAddrState;
    /** @var string ship address country by ISO 3166-1 3-digit numeric code */
    private string $shipAddrCountry;
    /** @var CardHolderPhoneNumber|null customer mobile phone */
    private ?CardHolderPhoneNumber $mobilePhone;
    /** @var CardHolderPhoneNumber|null customer home phone */
    private ?CardHolderPhoneNumber $homePhone;
    /** @var CardHolderPhoneNumber|null customer work phone */
    private ?CardHolderPhoneNumber $workPhone;
    /** @var string|null bill address line 2 if needed */
    private ?string $billAddrLine2;
    /** @var string|null bill address line 3 if needed */
    private ?string $billAddrLine3;
    /** @var string|null Indicates whether the Cardholder Shipping Address and Cardholder Billing Address are the same. Available values : Y, N. Its optional, payment gateway does not need it.*/
    private ?string $addrMatch;
    /** @var string|null ship address line 2 if needed */
    private ?string $shipAddrLine2;
    /** @var string|null ship address line 3 if needed */
    private ?string $shipAddrLine3;

    /**
     * @param string $cardHolderName Name of the Cardholder.
     * @param string $billAddrLine1 First line of the street address or equivalent local portion of the Cardholder billing address associated with the card used for this purchase.
     * @param string $billAddrPostCode ZIP or other postal code of the Cardholder billing address associated with the card used for this purchase.
     * @param string $billAddrCity The city of the Cardholder billing address associated with the card used for this purchase.
     * @param string $billAddrState The state or province of the Cardholder billing address associated with the card used for this purchase.The value should be the country subdivision code defined in ISO 3166-2.
     * @param string $billAddrCountry The country of the Cardholder billing address associated with the card used for this purchase. This value shall be the ISO 3166-1 numeric country code, except values from range 901 - 999 which are reserved by ISO.
     * @param string $email The email address associated with the account that is either entered by the Cardholder, or is on file with the 3DS Requestor. This field shall meet requirements of Section 3.4 of IETF RFC 5322.
     * @param string $shipAddrLine1 First line of the street address or equivalent local portion of the shipping address associated with the card used for this purchase.
     * @param string $shipAddrPostCode ZIP or other postal code of the shipping address associated with the card used for this purchase.
     * @param string $shipAddrCity City portion of the shipping address requested by the Cardholder. This field is required unless shipping information is the same as billing information.
     * @param string $shipAddrState The state or province of the shipping address associated with the card used for this purchase.
     * @param string $shipAddrCountry by the Cardholder. This value shall be the ISO 3166-1 numeric country code, except values from range 901 - 999 which are reserved by ISO. This field is required if Cardholder Shipping Address State is present and if shipping information is not the same as billing information.
     * @param CardHolderPhoneNumber|null $mobilePhone The mobile phone provided by the cardholder.
     * @param CardHolderPhoneNumber|null $homePhone The home phone provided by the cardholder.
     * @param CardHolderPhoneNumber|null $workPhone The work phone provided by the cardholder.
     * @param string|null $billAddrLine2 Second line of the street address or equivalent local portion of the Cardholder billing address associated with the card used for this purchase.
     * @param string|null $billAddrLine3 Third line of the street address or equivalent local portion of the Cardholder billing address associated with the card used for this purchase.
     * @param string|null $addrMatch Indicates whether the Cardholder Shipping Address and Cardholder Billing Address are the same. Available values : Y, N
     * @param string|null $shipAddrLine2 Second line of the street address or equivalent local portion of the shipping address associated with the card used for this purchase.
     * @param string|null $shipAddrLine3 Third line of the street address or equivalent local portion of the shipping address associated with the card used for this purchase.
     * @throws VariableLengthException
     * @throws VariableNotContainsException
     */
  public function __construct(
      string $cardHolderName,
      string $billAddrLine1,
      string $billAddrPostCode,
      string $billAddrCity,
      string $billAddrState,
      string $billAddrCountry,
      string $email,
      string $shipAddrLine1,
      string $shipAddrPostCode,
      string $shipAddrCity,
      string $shipAddrState,
      string $shipAddrCountry,
      ?CardHolderPhoneNumber $mobilePhone = null,
      ?CardHolderPhoneNumber $homePhone = null,
      ?CardHolderPhoneNumber $workPhone = null,
      ?string $billAddrLine2 = null,
      ?string $billAddrLine3 = null,
      ?string $addrMatch = null,
      ?string $shipAddrLine2 = null,
      ?string $shipAddrLine3 = null
  )
  {
      Utils::checkVariableLen($cardHolderName, 'cardHolderName', 50);

      Utils::checkVariableLen($billAddrLine1, 'billAddrLine1', 50);
      Utils::checkVariableLen($billAddrLine2, 'billAddrLine2', 50, true);
      Utils::checkVariableLen($billAddrLine3, 'billAddrLine3', 50, true);
      Utils::checkVariableLen($billAddrPostCode, 'billAddrPostCode', 16);
      Utils::checkVariableLen($billAddrCity, 'billAddrCity', 50);
      Utils::checkVariableLen($billAddrState, 'billAddrState', 3);
      Utils::checkVariableLen($billAddrCountry, 'billAddrCountry', 3);

      Utils::checkVariableLen($email, 'email', 256);


      Utils::checkValueContainsArgs($addrMatch, 'addrMatch','Y', 'N', null);

      Utils::checkVariableLen($shipAddrLine1, 'shipAddrLine1', 50);
      Utils::checkVariableLen($shipAddrLine2, 'shipAddrLine2', 50, true);
      Utils::checkVariableLen($shipAddrLine3, 'shipAddrLine3', 50, true);
      Utils::checkVariableLen($shipAddrPostCode, 'shipAddrPostCode', 16);
      Utils::checkVariableLen($shipAddrCity, 'shipAddrCity', 50);
      Utils::checkVariableLen($shipAddrState, 'shipAddrState', 3);
      Utils::checkVariableLen($shipAddrCountry, 'shipAddrCountry', 3);

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
      $this->addrMatch = $addrMatch;
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
     * returns if bill and ship address match, available values: null, Y, N
     * @return string|null
     */
    public function getAddrMatch(): ?string
    {
        return $this->addrMatch;
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