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
        /** merchantPaymentId is just your identification of payment, it should be random generated Guid */
        $merchantPaymentId = '476a8fc5-23db-4a5e-85ca-ed31b61a5a9d'; // random generated
        /** Three character currency code by ISO 4217 */
        $currency = 'EUR';
        /** amount is string without floating point, but last 2 digits are floating point. For example if we have amount 123, we want to pay 1.23 */
        $amount = '123';
        /** this number will we visible in portal zone */
        $orderNumber = '9999';
        /** to this url will be client redirected by payment gateway after processing */
        $redirectUrl = 'https://www.redirecturl.com';
        /** language used in paymant gateway interface if has translation */
        $language = 'sk-sk';

        return new PaymentRequest(
            'guid_methodId_from_registration_request', //methodId obtained from registration request
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

------

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

createPayments
--------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    function createPayments(): array
    {
        return [new Payment(
            Payment::PaymentIdCard, //Payment identifier -> card payment
            1.23, //paid amount
            'Payment description sent to portal' // description of payment will be displayed on portal
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

createBasketItems
-----------------

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    /**
        This function create just one basket item for demonstration, we can create as much as we want.
    */
    function createBasketItems(): array
    {
        /** the name of the item shown in report */
        $name = 'TestItem';
        $vatRate = 20.0;
        $quantity = 1;
        /** measure unit must be from available constatnts in BasketItem::MeasureUnits array */
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
        /** Name of customer */
        $cardHolderName = 'Test Test';
        /** Bill and ship addresses of customer */
        $billAddrLine1 = $shipAddrLine1 = 'Továrenská';
        $billAddrPostCode = $shipAddrPostCode = '020 01';
        $billAddrCity = $shipAddrCity = 'Púchov';
        /** State code by ISO 3166-2 */
        $billAddrState = $shipAddrState = 'ZI';
        /** State code by ISO 3166-1 numeric value */
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
        /** country number prefix */
        $countryCode = "421";
        /** subscriber section of phone number */
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