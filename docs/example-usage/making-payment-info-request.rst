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


Vysvetliť kód.