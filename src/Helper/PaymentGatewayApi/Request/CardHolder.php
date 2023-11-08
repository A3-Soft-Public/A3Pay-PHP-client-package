<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;


final class CardHolder extends \A3Soft\A3PayPhpClient\Helper\Util\AbstractToArray
{
    private string $cardHolderName;
    private string $billAddrLine1;
    private string $billAddrPostCode;
    private string $billAddrCity;
    private string $billAddrState;
    private string $billAddrCountry;
    private string $email;
    private string $shipAddrLine1;
    private string $shipAddrPostCode;
    private string $shipAddrCity;
    private string $shipAddrState;
    private string $shipAddrCountry;
    private ?CardHolderPhoneNumber $mobilePhone;
    private ?CardHolderPhoneNumber $homePhone;
    private ?CardHolderPhoneNumber $workPhone;
    private ?string $billAddrLine2;
    private ?string $billAddrLine3;
    private ?string $addrMatch;
    private ?string $shipAddrLine2;
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

    public function getCardHolderName(): string
    {
        return $this->cardHolderName;
    }

    public function getBillAddrLine1(): string
    {
        return $this->billAddrLine1;
    }

    public function getBillAddrPostCode(): string
    {
        return $this->billAddrPostCode;
    }

    public function getBillAddrCity(): string
    {
        return $this->billAddrCity;
    }

    public function getBillAddrState(): string
    {
        return $this->billAddrState;
    }

    public function getBillAddrCountry(): string
    {
        return $this->billAddrCountry;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getShipAddrLine1(): string
    {
        return $this->shipAddrLine1;
    }

    public function getShipAddrPostCode(): string
    {
        return $this->shipAddrPostCode;
    }

    public function getShipAddrCity(): string
    {
        return $this->shipAddrCity;
    }

    public function getShipAddrState(): string
    {
        return $this->shipAddrState;
    }

    public function getShipAddrCountry(): string
    {
        return $this->shipAddrCountry;
    }

    public function getMobilePhone(): ?CardHolderPhoneNumber
    {
        return $this->mobilePhone;
    }

    public function getHomePhone(): ?CardHolderPhoneNumber
    {
        return $this->homePhone;
    }

    public function getWorkPhone(): ?CardHolderPhoneNumber
    {
        return $this->workPhone;
    }

    public function getBillAddrLine2(): ?string
    {
        return $this->billAddrLine2;
    }

    public function getBillAddrLine3(): ?string
    {
        return $this->billAddrLine3;
    }

    public function getAddrMatch(): ?string
    {
        return $this->addrMatch;
    }

    public function getShipAddrLine2(): ?string
    {
        return $this->shipAddrLine2;
    }

    public function getShipAddrLine3(): ?string
    {
        return $this->shipAddrLine3;
    }

}