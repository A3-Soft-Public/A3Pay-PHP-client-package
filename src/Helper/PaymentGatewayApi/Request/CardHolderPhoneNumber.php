<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use A3Soft\A3PayPhpClient\Util\Utils;

final class CardHolderPhoneNumber extends AbstractToArray
{
    private string $cc;
    private string $subscriber;

    /**
     * @param string $countryCode Country Code of the phone. Min. length 1.
     * @param string $subscriber Subscriber section of the number.
     * @throws VariableLengthException
     */
  public function __construct(
      string $countryCode,
      string $subscriber
  )
  {
      Utils::checkVariableLen($countryCode, 'countryCode', 3, true);
      Utils::checkVariableLen($subscriber, 'subscriber',  15, true);
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