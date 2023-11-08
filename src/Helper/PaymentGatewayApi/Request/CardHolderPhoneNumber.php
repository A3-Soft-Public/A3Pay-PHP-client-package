<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

use A3Soft\A3PayPhpClient\Helper\Util\AbstractToArray;

final class CardHolderPhoneNumber extends AbstractToArray
{
    private string $cc;
    private string $subscriber;

    /**
     * @param string $countryCode Country Code of the phone. Min. length 1.
     * @param string $subscriber Subscriber section of the number.
     */
  public function __construct(
      string $countryCode,
      string $subscriber
  )
  {
      $this->cc = $countryCode;
      $this->subscriber = $subscriber;
  }

    public function getCountryCode(): string
    {
        return $this->cc;
    }

    public function getSubscriber(): string
    {
        return $this->subscriber;
    }

}