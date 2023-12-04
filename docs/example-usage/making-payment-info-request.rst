############
Info request
############

.. note::
    This type of request is made when we want to check status of payment request

Approach
========

- create :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentInfoRequest`.
- create :php:class:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester` service.

    As parameter we pass payment info url, not payment create url

- make request by calling :php:method:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester::makeRequest()` and passing :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentInfoRequest` as parameter.
- `$paymentInfoResponse` variable now has :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse` object type.
- for better operating we can create :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse` object by calling static method :php:method:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse::fromArray()`.

    This method need an array as parameter.

- an array should be easily obtained by calling :php:method:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse::json()` method, which will cast curl body response to array.
- now the variable `$infoResponse` has :php:class:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse` object type.
- so we can check for payment status by call :php:method:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse::getStatus()` method, or check if any error occurred by method :php:method:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse::getErrorMessage()`


.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once(__DIR__ . '/vendor/autoload.php');

    $paymentInfoRequest = new PaymentInfoRequest('paymentId-from-payment-response');
    $paymentInfoRequester = new PaymentGatewayRequester('https://api_info_url_from_registration_request', 'token_from_registration_request');

    try {
        $paymentInfoResponse = $paymentInfoRequester->makeRequest($paymentInfoRequest);
    } catch(\A3Soft\A3PayPhpClient\Exception\CurlRequestException $curlRequestException) {
        //log curl request exception, also we can check for $curlRequestException->getCurlResponse()
    }

    try {
        $infoResponse = PaymentInfoResponse::fromArray($paymentInfoResponse->json());
    } catch(\JsonException $jsonException) {
        //log json exception
    }

    //we may check if any error message was responded by
    $infoResponse->getErrorMessage();

    //and check if payment status was changed by comparing old status vs new one
    if($oldStatus !== $infoResponse->getStatus()) {
        //do stuff
    }



-------

.. hint::
    And it is all, we can that easily verify payment status