###############
Payment request
###############

.. toctree::
    :numbered:

    making-payment-request

.. note::
    This type of request is made when we want to create payment by FiskalPay API

For this type of request we have prepared :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentRequest` data object model.
This data model implements :php:interface:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentGatewayRequest` interface
and extends :php:class:`A3Soft\A3PayPhpClient\Util\AbstractToArray` abstract class.
All :php:namespace:`A3Soft\A3PayPhpClient\Helper` data models extends this class.
That mean you can use :php:method:`A3Soft\A3PayPhpClient\Util\AbstractToArray::toArray()` method (we will need it in future).


Walkthrough
###########

1. create :php:class:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester` service
2. create :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentRequest` instance by passing all parameters (data models)
3. call :php:method:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester::makeRequest()` method by passing :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentRequest` instance and save the :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse` result into a variable
4. surround :php:method:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester::makeRequest()` with try-catch block to catch :php:class:`A3Soft\A3PayPhpClient\Exception\CurlRequestException` exception when error occurred
5. parse `A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse` (returned by :php:method:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester::makeRequest()`) and create :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentResponse`
6. get link by :php:method:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentResponse::getRedirectUrl()` and process redirection
7. when the payment will be processed your notification hook (provided in registration) will be called, click :doc:`here<Payment notification handling>` to see example
8. client will be redirected back to url provided in request

Code
####

1. Create PaymentGatewayRequester service
==============================================

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');


`Arguments`
***********

* url  - url where the request may be send.
    * in this case we need to pass url for payment create request, not for payment info request
* access token - to verify if you have authority to proceed payments

.. note::
    Both of this values are obtained from *registration form*.

------

2. Create PaymentGatewayRequest
===============================

.. code-block:: php
    :caption: example.php
    :lineos:

    function createPaymentGatewayRequest(): PaymentRequest
    {
        /** merchantPaymentId is just your identification of payment, it should be random generated Guid */
        $merchantPaymentId = '476a8fc5-23db-4a5e-85ca-ed31b61a5a9d'; // random generated
        /** amount is string without floating point, but last 2 digits are floating point. For example if we have amount 123, we want to pay 1.23 */
        $amount = '123';
        /** order id */
        $orderNumber = '9999';
        /** to this url will be client redirected by payment gateway after processing */
        $redirectUrl = 'https://www.redirecturl.com';
        /** language used in payment gateway interface if has translation */
        $language = 'sk-sk';

        $email = null; // email where the the notice should be send, only available when PaymentReferenceType is set to PaymentReferenceType::Email
        $message = null // // body of email sent when payment realized, only available when PaymentReferenceType is set to PaymentReferenceType::Email

        return new PaymentRequest(
            $merchantPaymentId,
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
            PaymentReferenceType::Direct,
            $email,
            $message
        );
    }


.. note::
    If we want to easy generate an Guid, we can use `this library<https://github.com/ramsey/uuid>`_

`Arguments`
************

* merchantPaymentId - it is random generated guid, it can be useful when some error occurred, to identify payment
* amount - it is price, but in string without decimal point. it means the last two digits are cents (1224 -> 12.24, 5 -> 0.05, 75 -> 0.75, 10000 -> 100.00)
* orderNumber - the order identification, we can use database id for example
* :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\Basket` instance

    * To create `Basket` instance we must provide this instances

        * :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\BasketHeader` instance

        * array of :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\Payment` instances

        * :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\CustomerBasket` instance

        * array of :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\BasketItem` instances
* :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\CardHolder` instance
* redirectUrl - this url will be used after submitting payment, there are two cases what can happens. Success, or fail. This url is called in both.
* language - the language in `language code`-`country code` for example (sk-SK, cz-CZ, en-US, en-GB)
    * language code following `ISO 639-1<http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes>`_ standard
    * country code following `ISO 3166-1 Alpha-2<http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2>`_  standard
* :php:variable:`\A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentReferenceType` constant
* email - null or email address where the document will be send, just valid when :php:variable:`\A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentReferenceType` has been set to Email
* message - null or string, body of email, just valid when :php:variable:`\A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentReferenceType` has been set to Email

-------

2.1 CreateBasket
=================

.. code-block:: php
    :caption: example.php
    :lineos:

    function createBasket(BasketHeader $basketHeader, array $payments, CustomerBasket $customerBasket, array $basketItems): Basket
    {
        return new Basket(
            $basketHeader,
            $payments,
            $customerBasket,
            $basketItems
        );
    }

`Arguments`
************

* We just pass parameters we have got in arguments.

---------

2.2 Create BasketHeader
========================

.. code-block:: php
    :caption: example.php
    :lineos:

    function createBasketHeader(): BasketHeader
    {
        $documentNumber = "orderId"; // id of order
        $reference = 'REFERENCE';
        /** document rounding value */
        $rounding = 0;
        /** optional texts */
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

`Arguments`
************

* documentNumber - it is the id of order (for example database primary key)
* reference - order reference
* rounding - will be explained
* text1 - description text no. 1 (optional)
* text2 - description text no. 2 (optional)
* text3 - description text no. 3 (optional)

---------

2.3 CreatePayments
===================

.. error::
    This feature was not implemented yet. It is recommended to return an empty array.

.. code-block:: php
    :caption: example.php
    :lineos:

    function createPayments(): array
    {
        return [new Payment(
            Payment::PaymentIdVoucher, //Payment identifier -> voucher payment
            1.23, //paid amount
            'Payment description sent to portal' // description of payment will be displayed on portal
        )];
    }

.. note::
    We will return payment in array list only if we want to pay part of price by voucher for example

.. warning::
    No other payment methods than card are possible. It means we can pass null or return an empty array. This future will be implemented soon

----------

2.4 Create CustomerBasket
===========================

.. code-block:: php
    :caption: example.php
    :lineos:

    function createCustomerBasket(): CustomerBasket
    {
        /** optional field, id of customer */
        $customerNumber = null;
        /** optional fields card number and if we want to pass external id of 3rd party system, we can use $externalUid*/
        $cardNumber = $externalUid = null;
        return new CustomerBasket(
            $customerNumber,
            $cardNumber,
            $externalUid
        );
    }

`Arguments`
************

* customerNumber - customer identification (optional)
* cardNumber - this will be useful for remembered payments (optional)
* externalUid - this field should be filled when you have more customer ids (for example in external system) (optional)

----------

2.5 Create BasketItems
=======================

.. note::
    We can create as much BasketItems as we want. This items will be sent to portal for report.


.. code-block:: php
    :caption: example.php
    :lineos:

    /**
        This function create just one basket item for demonstration, we can create as much as we want.
    */
    function createBasketItems(): array
    {
        /** the name of the item shown in report */
        $name = 'TestItem';
        $vatRate = 20.0;
        $quantity = 1;
        /** measure unit must be from available constants in BasketItem::MeasureUnits array */
        $measureUnit = BasketItem::MeasureUnits['Ks'];
        /** price without vat, before discount per unit */
        $originalUnitPrice = 2.0;
        /** actual price without vat per unit */
        $unitPrice = 1.0;
        /** total price without vat */
        $priceTotal = 1.0;
        /** vat base for total price */
        $priceVatBaseTotal = 0.2;
        /** total price incl. vat */
        $priceVatTotal = 1.2;
        /** item rounding */
        $itemRounding = 0;
        /** the name of article if is register on FiskalPRO portal
        $article = "Article";
        /** chr1 and chr2 of product if it is paired product, only if the product is registered on portal.
        $chr1 = $chr2 = null; //not paired product
        /** ean of product / product variant */
        $ean = '1234567891234';
        /** external uid is used when we take product from 3rd party system */
        $externalUId = null;
        /** short text product description */
        $text1 = 'Text1';
        /** long text product description */
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

`Arguments`
************

* name - name of basket item (product)
* vatRate - vat rate when realizing order
* quantity - count of measureUnit
* measureUnit - measure unit must be from available constants in :php:property:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\BasketItem::MeasureUnits` array
* originalUnitPrice - price without vat, before discount per unit
* priceTotal - total price without vat
* priceVatBaseTotal - vat base for total price
* priceVatTotal - total price incl. vat
* itemRounding - will be explained
* article - the name of product (send to portal)
* chr1 - it should be for example size (S, M, L, XL, ...) - (optional) field, should be filled only if product have attributes
* chr2 - it should be for example color (red, blue, ...) - (optional) field, should be filled only if product have attributes
* ean - ean of product / product variant
* externalUId - external uid is used when we take product from 3rd party system
* text1 - short text product description
* text1Long - long text product description

------------

2.6 Create CardHolder
======================

.. code-block:: php
    :caption: example.php
    :lineos:

    function createCardHolder(): CardHolder
    {
        /** Name of customer */
        $cardHolderName = 'Test Test';
        /** Bill and ship addresses of customer */
        $billAddrLine1 = $shipAddrLine1 = 'Továrenská';
        $billAddrPostCode = $shipAddrPostCode = '020 01';
        $billAddrCity = $shipAddrCity = 'Púchov';
        /** State code by ISO 3166-2 or null (optional)*/
        $billAddrState = $shipAddrState = null;
        /** State code by ISO 3166-1 numeric value */
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
            $shipAddrState
        );
    }

`Arguments`
************
* string $cardHolderName - Name of the Cardholder
* string $email - The email address associated with the account that is either entered by the Cardholder, or is on file with the 3DS Requestor.
* CardHolderPhoneNumber|null $mobilePhone - The mobile phone provided by the cardholder.
* CardHolderPhoneNumber|null $homePhone - The home phone provided by the cardholder.
* CardHolderPhoneNumber|null $workPhone - The work phone provided by the cardholder.
* string|null $billAddrLine1  - First line of the street address or equivalent local portion of the Cardholder billing address associated with the card used for this purchase. This field is optional, but recommended to include.
* string|null $billAddrLine2  - Second line of the street address or equivalent local portion of the Cardholder billing address associated with the card used for this purchase.
* string|null $billAddrLine3  - Third line of the street address or equivalent local portion of the Cardholder billing address associated with the card used for this purchase.
* string|null $billAddrPostCode  - ZIP or other postal code of the Cardholder billing address associated with the card used for this purchase. This field is optional, but recommended to include.
* string|null $billAddrCity  - The city of the Cardholder billing address associated with the card used for this purchase. This field is optional, but recommended to include.
* string|null $billAddrState  - The state or province of the Cardholder billing address associated with the card used for this purchase. The value should be the country subdivision code defined in ISO 3166-2. This field is optional, but recommended to include.
* string|null $billAddrCountry  - The country of the Cardholder billing address associated with the card used for this purchase. This value shall be the ISO 3166-1 numeric country code, except values from range 901 - 999 which are reserved by ISO. This field is optional, but recommended to include.
* string|null $shipAddrLine1  - First line of the street address or equivalent local portion of the shipping address associated with the card used for this purchase. This field is optional, but recommended to include.
* string|null $shipAddrLine2  - Second line of the street address or equivalent local portion of the shipping address associated with the card used for this purchase.
* string|null $shipAddrLine3  - Third line of the street address or equivalent local portion of the shipping address associated with the card used for this purchase.
* string|null $shipAddrPostCode  - ZIP or other postal code of the shipping address associated with the card used for this purchase. This field is optional, but recommended to include.
* string|null $shipAddrCity  - City portion of the shipping address requested by the Cardholder. This field is required unless shipping information is the same as billing information. This field is optional, but recommended to include.
* string|null $shipAddrCountry  - The state or province of the shipping address associated with the card used for this purchase.
* string|null $shipAddrState  - Country of the shipping address requested by the Cardholder. This value shall be the ISO 3166-1 numeric country code, except values from range 901 - 999 which are reserved by ISO. This field is required if Cardholder Shipping Address State is present and if shipping information is not the same as billing information. This field is optional, but recommended to include.

2.7 Create CardHolderPhoneNumber
=================================

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    function createCardHolderPhoneNumber(): CardHolderPhoneNumber
    {
        /** country number prefix */
        $countryCode = "421";
        /** subscriber section of phone number */
        $subscriber = "123456789";
        return new CardHolderPhoneNumber(
            $countryCode,
            $subscriber
        );
    }

`Arguments`
************

* countryCode - country code of the phone. Min. length 1
* subscriber - subscriber section of the number

--------

3. Make request
================

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');
    $paymentGatewayRequest = createPaymentGatewayRequest();
    $curlResponse = $paymentGatewayRequester->makeRequest($paymentGatewayRequest);

4. Surround makeRequest with try-catch
=======================================

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');
    $paymentGatewayRequest = createPaymentGatewayRequest();
    try {
        $curlResponse = $paymentGatewayRequester->makeRequest($paymentGatewayRequest);
    } catch(\A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse $curlResponse) {
        LogError($curlResponse->getCurlResponse()->getErrorMessage());
        die;
    }

    echo "Request responseCode: {$curlResponse->getStatusCode()}" . PHP_EOL;
    echo "Request raw body: {$curlResponse->getBody()}" . PHP_EOL;
    try {
        echo "Request parsed data: {$curlResponse->json()}" . PHP_EOL;
    } catch(\JsonException $jsonException) {
        echo "Json could not be parsed!" . $jsonException->getMessage() . PHP_EOL;
    }

5. Parse data and create PaymentResponse
=========================================

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');
    $paymentGatewayRequest = createPaymentGatewayRequest();
    try {
        $curlResponse = $paymentGatewayRequester->makeRequest($paymentGatewayRequest);
    } catch(\A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse $curlResponse) {
        LogError($curlResponse->getCurlResponse()->getErrorMessage());
        die;
    }

    echo "Request responseCode: {$curlResponse->getStatusCode()}" . PHP_EOL;
    echo "Request raw body: {$curlResponse->getBody()}" . PHP_EOL;
    try {
        $parsedPaymentResponseData = $curlResponse->json();
    } catch(\JsonException $jsonException) {
        echo "Json could not be parsed!" . $jsonException->getMessage() . PHP_EOL;
        die;
    }

    try {
        $paymentResponse = PaymentResponse::fromArray($parsedPaymentResponseData);
    } catch(\Exception $exception) {
        //Exception is thrown when parsed data does not match data object.
        echo $exception->getMessage() . PHP_EOL;
    }


6. Get link and redirect
=========================================

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');
    $paymentGatewayRequest = createPaymentGatewayRequest();
    try {
        $curlResponse = $paymentGatewayRequester->makeRequest($paymentGatewayRequest);
    } catch(\A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse $curlResponse) {
        LogError($curlResponse->getCurlResponse()->getErrorMessage());
        die;
    }

    echo "Request responseCode: {$curlResponse->getStatusCode()}" . PHP_EOL;
    echo "Request raw body: {$curlResponse->getBody()}" . PHP_EOL;
    try {
        $parsedPaymentResponseData = $curlResponse->json();
    } catch(\JsonException $jsonException) {
        echo "Json could not be parsed!" . $jsonException->getMessage() . PHP_EOL;
        die;
    }

    try {
        $paymentResponse = PaymentResponse::fromArray($parsedPaymentResponseData);
    } catch(\Exception $exception) {
        //Exception is thrown when parsed data does not match data object.
        echo $exception->getMessage() . PHP_EOL;
    }
    // we need to save paymentId, it should be paired with `merchantPaymentId`, from step 2 (for example new table with: id (primary), id of order, merchantPaymentId, and paymentId from payment request)
    $paymentId = $paymentResponse->getPaymentId();
    //createPaymentOrderRecord($orderId, $merchantPaymentId, $paymentId);

    //and at the end, redirect to payment gateway
    header("Location: ${$paymentResponse->getRedirectUrl()}");

Full code
==========
.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');
    $paymentGatewayRequest = createPaymentGatewayRequest();
    try {
        $curlResponse = $paymentGatewayRequester->makeRequest($paymentGatewayRequest);
    } catch(\A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse $curlResponse) {
        LogError($curlResponse->getCurlResponse()->getErrorMessage());
        die;
    }

    echo "Request responseCode: {$curlResponse->getStatusCode()}" . PHP_EOL;
    echo "Request raw body: {$curlResponse->getBody()}" . PHP_EOL;
    try {
        $parsedPaymentResponseData = $curlResponse->json();
    } catch(\JsonException $jsonException) {
        echo "Json could not be parsed!" . $jsonException->getMessage() . PHP_EOL;
        die;
    }

    try {
        $paymentResponse = PaymentResponse::fromArray($parsedPaymentResponseData);
    } catch(\Exception $exception) {
        //Exception is thrown when parsed data does not match data object.
        echo $exception->getMessage() . PHP_EOL;
    }
    // we need to save paymentId, it should be paired with `merchantPaymentId`, from step 2 (for example new table with: id (primary), id of order, merchantPaymentId, and paymentId from payment request)
    $paymentId = $paymentResponse->getPaymentId();
    //createPaymentOrderRecord($orderId, $merchantPaymentId, $paymentId);

    //and at the end, redirect to payment gateway
    header("Location: ${$paymentResponse->getRedirectUrl()}");

    /** Function definition */
    function createPaymentGatewayRequest(): PaymentRequest
        {
            /** merchantPaymentId is just your identification of payment, it should be random generated Guid */
            $merchantPaymentId = '476a8fc5-23db-4a5e-85ca-ed31b61a5a9d'; // random generated
            /** amount is string without floating point, but last 2 digits are floating point. For example if we have amount 123, we want to pay 1.23 */
            $amount = '123';
            /** order id */
            $orderNumber = '9999';
            /** to this url will be client redirected by payment gateway after processing */
            $redirectUrl = 'https://www.redirecturl.com';
            /** language used in payment gateway interface if has translation */
            $language = 'sk-sk';

            $email = null; // email where the the notice should be send, only available when PaymentReferenceType is set to PaymentReferenceType::Email
            $message = null // // body of email sent when payment realized, only available when PaymentReferenceType is set to PaymentReferenceType::Email

            return new PaymentRequest(
                $merchantPaymentId,
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
                PaymentReferenceType::Direct,
                $email,
                $message
            );
        }

    function createBasket(BasketHeader $basketHeader, array $payments, CustomerBasket $customerBasket, array $basketItems): Basket
    {
        return new Basket(
            $basketHeader,
            $payments,
            $customerBasket,
            $basketItems
        );
    }

    function createBasketHeader(): BasketHeader
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

    function createPayments(): array
    {
        /** If we want to pay all the load by card, we must return an empty array */
        return [];
    }


    function createCustomerBasket(): CustomerBasket
    {
        $customerNumber = null;
        $cardNumber = $externalUid = null;
        return new CustomerBasket(
            $customerNumber,
            $cardNumber,
            $externalUid
        );
    }


    function createBasketItems(): array
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

    function createCardHolder(): CardHolder
    {
        /** Name of customer */
        $cardHolderName = 'Test Test';
        /** Bill and ship addresses of customer */
        $billAddrLine1 = $shipAddrLine1 = 'Továrenská';
        $billAddrPostCode = $shipAddrPostCode = '020 01';
        $billAddrCity = $shipAddrCity = 'Púchov';
        /** State code by ISO 3166-2 or null (optional)*/
        $billAddrState = $shipAddrState = null;
        /** State code by ISO 3166-1 numeric value */
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
            $shipAddrState
        );
    }

    function createCardHolderPhoneNumber(): CardHolderPhoneNumber
    {
        $countryCode = "421";
        $subscriber = "123456789";
        return new CardHolderPhoneNumber(
            $countryCode,
            $subscriber
        );
    }

----------

Next article is :doc:`Payment notification handling`