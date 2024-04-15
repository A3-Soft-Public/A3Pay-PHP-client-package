<?php
declare(strict_types=1);

namespace A3Soft\A3PayPhpClient\Tests\PaymentGatewayApi;

use A3Soft\A3PayPhpClient\Exception\CurlRequestException;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\Basket;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\BasketHeader;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\BasketItem;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\CardHolder;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\CardHolderPhoneNumber;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\CustomerBasket;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\Payment;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentInfoRequest;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentReferenceType;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentRequest;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentResponse;
use A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester;
use Nette\Neon\Neon;
use PHPUnit\Framework\TestCase;


/**
 * @package Test
 */
final class PaymentGatewayRequesterTest extends TestCase
{
    const RequestConfigFile = __DIR__ . '/../../requesterTestCredentials.neon';
    private string $requestLink;
    private string $requestInfoLink;
    private string $requestToken;
    private string $merchantPaymentId;
    private string $danubeTerminalId;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $configFile = self::RequestConfigFile;
        if(!file_exists($configFile))
            throw new \Exception("Request config file does not exist!");
        $data = Neon::decodeFile($configFile);
        if (!isset($data['requestLink']))
            throw new \Exception("The field \"requestLink\" in File \"{$configFile}\" does not exist");
        if (!isset($data['requestInfoLink']))
            throw new \Exception("The field \"requestInfoLink\" in File \"{$configFile}\" does not exist");
        if (!isset($data['requestToken']))
            throw new \Exception("The field \"requestToken\" in File \"{$configFile}\" does not exist");
        if (!isset($data['merchantPaymentId']))
            throw new \Exception("The field \"merchantPaymentId\" in File \"{$configFile}\" does not exist");

        $this->requestLink = $data['requestLink'];
        $this->requestInfoLink = $data['requestInfoLink'];
        $this->requestToken = $data['requestToken'];
        $this->merchantPaymentId = $data['merchantPaymentId'];
    }

    public function testCurlException()
    {
        $this->expectException(CurlRequestException::class);
        $paymentGatewayRequester = new PaymentGatewayRequester("https://neexistuje.asdf", 'Bad Token');
        $paymentGatewayRequest = $this->createPaymentGatewayRequest();
        $paymentGatewayRequester->makeRequest($paymentGatewayRequest);
    }
    public function testPaymentGatewayRequestNotAuthorized()
    {
        $paymentGatewayRequester = new PaymentGatewayRequester($this->requestLink, 'Bad Token');
        $paymentGatewayRequest = $this->createPaymentGatewayRequest();

        $response = $paymentGatewayRequester->makeRequest($paymentGatewayRequest);
        $this->assertSame(401, $response->getStatusCode());
    }
    public function testPaymentGatewayRequest()
    {
        $paymentGatewayRequester = new PaymentGatewayRequester($this->requestLink, $this->requestToken);

        $paymentGatewayRequest = $this->createPaymentGatewayRequest();

        try {
            $response = $paymentGatewayRequester->makeRequest($paymentGatewayRequest);
        } catch (CurlRequestException $e) {
            echo "Error: " . $e->getCurlResponse()->getBody() . "Status code: " . $e->getCurlResponse()->getStatusCode() . PHP_EOL;
            ob_flush();
            throw $e;
        }
        echo 'Response:' ;
        print_r($response);
        ob_flush();

        $this->assertSame(200, $response->getStatusCode(), 'Response status code should be 200');

        $paymentResponse = PaymentResponse::fromArray($response->json());

        $this->assertNotEmpty($paymentResponse->getPaymentId(), 'Payment Id should not be empty');
        $this->assertNotEmpty($paymentResponse->getRedirectUrl(), 'Redirect url should not be empty');

        $paymentInfoRequest = new PaymentInfoRequest($paymentResponse->getPaymentId());
        $paymentInfoRequester = new PaymentGatewayRequester($this->requestInfoLink, $this->requestToken);

        $paymentInfoResponse = $paymentInfoRequester->makeRequest($paymentInfoRequest);

        $infoResponse = PaymentInfoResponse::fromArray($paymentInfoResponse->json());

        $this->assertNotEmpty($infoResponse->getStatus());
        $this->assertSame($infoResponse->getStatus(), PaymentInfoResponse::StatusCreated, "Expected PaymentInfoResponse was: " . PaymentInfoResponse::StatusNew);
    }


    private function createPaymentGatewayRequest(): PaymentRequest
    {
        $amount = '123';
        $orderNumber = '9999';
        $redirectUrl = 'https://www.redirecturl.com';
        $language = 'sk-sk';
        $email = null; // only when type is Email
        $message = null;

        return new PaymentRequest(
            $this->merchantPaymentId,
            $amount,
            $orderNumber,
            $this->createBasket(
                $this->createBasketHeader(),
                $this->createPayments(),
                $this->createCustomerBasket(),
                $this->createBasketItems()
            ),
            $this->createCardHolder(),
            $redirectUrl,
            $language,
            PaymentReferenceType::Test,
            $email,
            $message
        );
    }


    /**
     * @param BasketHeader $basketHeader
     * @param Payment[] $payments
     * @param CustomerBasket $customerBasket
     * @param BasketItem[] $basketItems
     * @return Basket
     */
    private function createBasket(BasketHeader $basketHeader, array $payments, CustomerBasket $customerBasket, array $basketItems): Basket
    {
        return new Basket(
            $basketHeader,
            $payments,
            $customerBasket,
            $basketItems
        );
    }

    private function createBasketHeader(): BasketHeader
    {
        $documentNumber = "GUID";
        $reference = 'REFERENCE';
        $rounding = 0;
        $text1 = $text2 = $text3 = null;
        return new BasketHeader(
            $documentNumber,
            $reference,
            $rounding,
            $text1,
            $text2,
            $text3
        );
    }


    /**
     * @return Payment[]
     */
    private function createPayments(): array
    {
        /*new Payment(
            Payment::PaymentIdCard,
            1.23,
            'Payment description sent to portal'
        )*/
        /** This should return values only if there's any other type for example voucher. */
        return [];
    }


    private function createCustomerBasket(): CustomerBasket
    {
        $customerNumber = null;
        $cardNumber = $externalUid = null;
        return new CustomerBasket(
            $customerNumber,
            $cardNumber,
            $externalUid
        );
    }


    private function createBasketItems(): array
    {
        $name = 'TestItem';
        $vatRate = 20.0;
        $quantity = 1;
        $measureUnit = BasketItem::MeasureUnits['Ks'];
        $originalUnitPrice = 2.0;
        $unitPrice = 1.0;
        $priceTotal = 1.0;
        $priceVatBaseTotal = 0.2;
        $priceVatTotal = 1.2;
        $itemRounding = 0;
        $article = "Article";
        $chr1 = $chr2 = null; //not paired product
        $ean = '1234567891234';
        $externalUId = null;
        $text1 = 'Text1';
        $text1Long = 'Text1Long';
        return [
            new BasketItem(
                $name,
                $vatRate,
                $quantity,
                $measureUnit,
                $originalUnitPrice,
                $unitPrice,
                $priceTotal,
                $priceVatBaseTotal,
                $priceVatTotal,
                $itemRounding,
                $article,
                $chr1,
                $chr2,
                $ean,
                $externalUId,
                $text1,
                $text1Long
            )];
    }

    /*private function createDanubePay(): DanubePay
    {
        return new DanubePay(
            $this->danubeTerminalId,
            $this->createCardHolder()
        );
    }*/

    private function createCardHolder(): CardHolder
    {
        $cardHolderName = 'Test Test';
        $billAddrLine1 = $shipAddrLine1 = 'Továrenská';
        $billAddrPostCode = $shipAddrPostCode = '020 01';
        $billAddrCity = $shipAddrCity = 'Púchov';
        $billAddrCountry = $shipAddrCountry = '703';
        $email = 'admin@a3soft.sk';

        return new CardHolder(
            $cardHolderName,
            $email,
            $this->createCardHolderPhoneNumber(),
            $this->createCardHolderPhoneNumber(),
            $this->createCardHolderPhoneNumber(),
            $billAddrLine1,
            null,
            null,
            $billAddrPostCode,
            $billAddrCity,
            null,
            $billAddrCountry,
            $shipAddrLine1,
            null,
            null,
            $shipAddrPostCode,
            $shipAddrCity,
            $shipAddrCountry,
            $shipAddrState,
        );
    }

    private function createCardHolderPhoneNumber(): CardHolderPhoneNumber
    {
        $countryCode = "421";
        $subscriber = "123456789";
        return new CardHolderPhoneNumber(
            $countryCode,
            $subscriber
        );
    }
}