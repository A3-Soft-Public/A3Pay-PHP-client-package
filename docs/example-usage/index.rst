#####
Usage
#####

.. note::
    We will use code snippets from tests to demonstrate how to use this library.

The core of this package is :php:class:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester` service.

All classes from namespace :php:namespace:`A3Soft\A3PayPhpClient\Helper` are just data models required to make API request.

Constructing :php:class:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester` service.
==================================================================================================

.. note::
    If we want to construct `PaymentGatewayRequester` service, we need **url link** and **access token**

.. code-block:: php
    :caption: example.php
    :linenos:

    <?php

        $paymentGatewayRequester = new PaymentGatewayRequester('https://api_url_from_registration_request', 'token_from_registration_request');

OK, if we have :php:class:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester` service, we need to make request. Requests are made using :php:method:`A3Soft\A3PayPhpClient\PaymentGatewayApi\PaymentGatewayRequester::makeRequest()` method.

This method require array of key - value pairs, or an object implementing :php:interface:`A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentGatewayRequest` interface.

We know two types of request:

- :doc:`Payment request`
- :doc:`Info request`

-------

Table of contents:
==================

.. toctree::
    :maxdepth: 3

    making-payment-request
    making-payment-info-request