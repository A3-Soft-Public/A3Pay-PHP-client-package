###############
Payment request
###############

.. note::
    This type of request is made when we want to make payment request to FiskalPay API

For this type of request we have prepared :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentRequest` data object model.
This data model implements :php:interface:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentGatewayRequest` interface
and extends :php:class:`A3Soft\A3PayPhpClient\Util\AbstractToArray` abstract class.
All :php:namespace:`A3Soft\A3PayPhpClient\Helper` data models extends this class.
That mean you can use :php:method:`A3Soft\A3PayPhpClient\Util\AbstractToArray::toArray()` method (we will need it in future).

So, we are going to create :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentRequest` instance


createPaymentGatewayRequest
---------------------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    function createPaymentGatewayRequest(): PaymentRequest
    {
        $merchantPaymentId = '476a8fc5-23db-4a5e-85ca-ed31b61a5a9d'; // random generated
        $currency = 'EUR';
        $amount = '123';
        $orderNumber = '9999';
        $redirectUrl = 'https://www.redirecturl.com';
        $language = 'sk-sk';

        return new PaymentRequest(
            'guid_methodId_from_registration_request',
            $merchantPaymentId,
            $currency,
            $amount,
            $orderNumber,
            $this->createBasket(
                $this->createBasketHeader(),
                $this->createPayments(),
                $this->createCustomerBasket(),
                $this->createBasketItems()
            ),
            $redirectUrl,
            $this->createDanubePay(),
            $language
        );
    }

As we can see, we need to create instances of:

* :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\Basket` instance

    * To create `Basket` instance we must provide this instances

        * :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\BasketHeader` instance

        * array of :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\Payment` instances

        * :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\CustomerBasket` instance

        * array of :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\BasketItem` instances

* :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\DanubePay` instance

createBasket
------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    function createBasket(BasketHeader $basketHeader, array $payments, CustomerBasket $customerBasket, array $basketItems): Basket
    {
        return new Basket(
            $basketHeader,
            $payments,
            $customerBasket,
            $basketItems
        );
    }


createBasketHeader
------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

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

createPayments
--------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    function createPayments(): array
    {
        return [new Payment(
            Payment::PaymentIdCard,
            1.23,
            'Payment description sent to portal'
        )];
    }

createCustomerBasket
--------------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

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

createBasketItems
-----------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

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

createDanubePay
---------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    function createDanubePay(): DanubePay
    {
        return new DanubePay(
            $this->danubeTerminalId,
            $this->createCardHolder()
        );
    }

createCardHolder
----------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    function createCardHolder(): CardHolder
    {
        $cardHolderName = 'Test Test';
        $billAddrLine1 = $shipAddrLine1 = 'Továrenská';
        $billAddrPostCode = $shipAddrPostCode = '020 01';
        $billAddrCity = $shipAddrCity = 'Púchov';
        $billAddrState = $shipAddrState = 'ZI';
        $billAddrCountry = $shipAddrCountry = '703';
        $email = 'admin@a3soft.sk';

        return new CardHolder(
            $cardHolderName,
            $billAddrLine1,
            $billAddrPostCode,
            $billAddrCity,
            $billAddrState,
            $billAddrCountry,
            $email,
            $shipAddrLine1,
            $shipAddrPostCode,
            $shipAddrCity,
            $shipAddrState,
            $shipAddrCountry,
            $this->createCardHolderPhoneNumber(),
            $this->createCardHolderPhoneNumber(),
            $this->createCardHolderPhoneNumber(),
        );
    }

createCardHolderPhoneNumber
---------------------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    function createCardHolderPhoneNumber(): CardHolderPhoneNumber
    {
        $countryCode = "421";
        $subscriber = "123456789";
        return new CardHolderPhoneNumber(
            $countryCode,
            $subscriber
        );
    }


Full code
---------
.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');

    function createPaymentGatewayRequest(): PaymentRequest
    {
        $merchantPaymentId = '476a8fc5-23db-4a5e-85ca-ed31b61a5a9d'; // random generated
        $currency = 'EUR';
        $amount = '123';
        $orderNumber = '9999';
        $redirectUrl = 'https://www.redirecturl.com';
        $language = 'sk-sk';

        return new PaymentRequest(
            'guid_methodId_from_registration_request',
            $merchantPaymentId,
            $currency,
            $amount,
            $orderNumber,
            $this->createBasket(
                $this->createBasketHeader(),
                $this->createPayments(),
                $this->createCustomerBasket(),
                $this->createBasketItems()
            ),
            $redirectUrl,
            $this->createDanubePay(),
            $language
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
        return [new Payment(
            Payment::PaymentIdCard,
            1.23,
            'Payment description sent to portal'
        )];
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

    function createDanubePay(): DanubePay
    {
        return new DanubePay(
            $this->danubeTerminalId,
            $this->createCardHolder()
        );
    }

    function createCardHolder(): CardHolder
    {
        $cardHolderName = 'Test Test';
        $billAddrLine1 = $shipAddrLine1 = 'Továrenská';
        $billAddrPostCode = $shipAddrPostCode = '020 01';
        $billAddrCity = $shipAddrCity = 'Púchov';
        $billAddrState = $shipAddrState = 'ZI';
        $billAddrCountry = $shipAddrCountry = '703';
        $email = 'admin@a3soft.sk';

        return new CardHolder(
            $cardHolderName,
            $billAddrLine1,
            $billAddrPostCode,
            $billAddrCity,
            $billAddrState,
            $billAddrCountry,
            $email,
            $shipAddrLine1,
            $shipAddrPostCode,
            $shipAddrCity,
            $shipAddrState,
            $shipAddrCountry,
            $this->createCardHolderPhoneNumber(),
            $this->createCardHolderPhoneNumber(),
            $this->createCardHolderPhoneNumber(),
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

Vysvetliť kód
