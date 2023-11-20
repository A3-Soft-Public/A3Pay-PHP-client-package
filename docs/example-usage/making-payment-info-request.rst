############
Info request
############

.. note::
    This type of request is made when we want to check status of payment request


.. code-block:: php
    :caption: example.php
    :lineos:

    <?php

    $paymentInfoRequest = new PaymentInfoRequest('paymentId-from-payment-response');
    $paymentInfoRequester = new PaymentGatewayRequester('https://api_info_url_from_registration_request', 'token_from_registration_request');

    $paymentInfoResponse = $paymentInfoRequester->makeRequest($paymentInfoRequest);

    $infoResponse = PaymentInfoResponse::fromArray($paymentInfoResponse->json());

-------

Approach
========

- create :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentInfoRequest`.
- create :php:class:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester` service.
- make request by calling :php:method:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester::makeRequest()` and passing :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentInfoRequest` as parameter.
- `$paymentInfoResponse` variable now has :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse` object type.
- for better operating we can create :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse` object by calling static method :php:method:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse::fromArray()`. This method need an array as parameter.
- an array should be easily obtained by calling :php:method:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse::json()` method, which will cast curl body response to array.
- now the variable `$infoResponse` has :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse` object type.
- so we can check for payment status by call :php:method:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse::getStatus()` method, or check if any error occurred by method :php:method:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse::getErrorMessage()`