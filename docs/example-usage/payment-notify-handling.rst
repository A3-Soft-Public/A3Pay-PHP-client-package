#############################
Payment notification handling
#############################

.. note::
    * If using any framework, you must use their documentation how to create handle signal for get request
    * We will create example in native php

.. toctree::
    :numbered:

    payment-notify-handling


.. note::
    As we are creating tutorial for raw php, we assumed the link will be `example.com/payment-notify-handling.php`.

    Payment gateway api will call our hook with these get parameters:

    * paymentId (string) - paymentId returned from payment request
    * status (string) - status of payment (:php:property:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse::Statuses`)


Payment statuses
#################

Payment status is represented by string, and can contain these values:

* Created - payment was established
* New - initial state, submitted for processing
* Authorized - approved by issuer
* Declined - not approved by issuer
* Reversed - payment was canceled
* Captured - funds were received
* Error - error during payment

.. hint::
    All these values are stored in :php:property:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\PaymentInfoResponse::Statuses`


1. Creating file
#################

* create file named `payment-notify-handling.php` in root of your web server

---------

2. Retrieve parameters from request
####################################

.. code-block:: php
    :caption: payment-notify-handling.php
    :lineos:

    <?php
    require_once(__DIR__ . '/vendor/autoload.php');

    if(!isset($_GET['paymentId']) || !isset($_GET['status'])) {
        echo 'Missing get parameters!';
        die;
    }

    $paymentId = $_GET['paymentId'];
    $status = $_GET['status'];

------------

3. Create PaymentGatewayRequester service
##########################################

.. warning::
    In this case we dont need status parameter from api, because it is untrusted!

.. note::
    Before we passed create payment url, now we need to pass payment info url.

    Token is same as before.

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    if(!isset($_GET['paymentId'])) {
        echo 'Missing get parameters!';
        die;
    }

    $paymentId = $_GET['paymentId'];

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');


`Arguments`
***********

* url  - url where the request may be send.
    * in this case we need to pass url for payment info request, not for payment create request
* access token - to verify if you have authority to proceed payments

.. note::
    Both of this values are obtained from *registration form*.

-----------

4. Create InfoRequest
#####################

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    if(!isset($_GET['paymentId'])) {
        echo 'Missing get parameters!';
        die;
    }

    $paymentId = $_GET['paymentId'];

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');

    $paymentInfoRequest = new PaymentInfoRequest($paymentId);

`Arguments`
***********

* paymentId  - parsed from get parameter

-------------

6. Make PaymentInfoRequest
###########################

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    if(!isset($_GET['paymentId'])) {
        echo 'Missing get parameters!';
        die;
    }

    $paymentId = $_GET['paymentId'];

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');

    $paymentInfoRequest = new PaymentInfoRequest($paymentId);

    try {
        $curlInfoResponse = $paymentGatewayRequester->makeRequest($paymentInfoRequest);
    } catch(\A3Soft\A3PayPhpClient\Exception\CurlException $curlException) {
        //retrieve curlResponse, log error
    }

--------

6. Parse PaymentInfoRequest
############################

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    if(!isset($_GET['paymentId'])) {
        echo 'Missing get parameters!';
        die;
    }

    $paymentId = $_GET['paymentId'];

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');

    $paymentInfoRequest = new PaymentInfoRequest($paymentId);

    try {
        $curlInfoResponse = $paymentGatewayRequester->makeRequest($paymentInfoRequest);
    } catch(\A3Soft\A3PayPhpClient\Exception\CurlException $curlException) {
        //retrieve curlResponse, log error
    }

    try {
        $paymentInfoResponse = PaymentInfoResponse::fromArray($curlInfoResponse::json())
    } catch(\Exception $exception) {
        //log json error
    }


7. Update order payment status
###############################

.. code-block:: php
    :caption: example.php
    :lineos:

    <?php
    require_once __DIR__ '/vendor/autoload.php';

    if(!isset($_GET['paymentId'])) {
        echo 'Missing get parameters!';
        die;
    }

    $paymentId = $_GET['paymentId'];

    $paymentGatewayRequester = new PaymentGatewayRequester("https://api_url_from_registration_request", 'token_from_registration_request');

    $paymentInfoRequest = new PaymentInfoRequest($paymentId);

    try {
        $curlInfoResponse = $paymentGatewayRequester->makeRequest($paymentInfoRequest);
    } catch(\A3Soft\A3PayPhpClient\Exception\CurlException $curlException) {
        //retrieve curlResponse, log error
    }

    try {
        $paymentInfoResponse = PaymentInfoResponse::fromArray($curlInfoResponse::json())
    } catch(\Exception $exception) {
        //log json error
    }

    // check for error message by
    $paymentErrorMessage = $paymentInfoResponse->getErrorMessage();
    //get payment status by
    $paymentStatus = $paymentInfoResponse->getStatus();

    //retrieve order id from hash table by paymentId (was recommended to save paymentId after payment request made)
    $orderId = getOrderIdByPaymentId($paymentId);

    //set order state based on paymentStatus :)
    setOrderPaymentStatus($orderId, $paymentStatus);


.. hint::
    Redirect url should be called after notify hook, so if you perform changing order status, it may be changed when you enter redirect url.