# A3Pay PHP client package

<!-- TOC -->
* [A3Pay PHP client package](#a3pay-php-client-package)
* [Overview](#overview)
* [Request](#request)
* [Installation](#installation)
  * [Install using composer](#install-using-composer)
  * [Getting started](#getting-started)
    * [Package classes](#package-classes)
      * [Request](#request-1)
      * [Response](#response-)
      * [Requester](#requester)
      * [Exceptions](#exceptions)
      * [Utils](#utils)
  * [Collaborate with your team](#collaborate-with-your-team)
  * [Test and Deploy](#test-and-deploy)
* [Editing this README](#editing-this-readme)
  * [Suggestions for a good README](#suggestions-for-a-good-readme)
  * [Name](#name)
  * [Description](#description)
  * [Badges](#badges)
  * [Visuals](#visuals)
  * [Installation](#installation-1)
  * [Usage](#usage)
  * [Support](#support)
  * [Roadmap](#roadmap)
  * [Contributing](#contributing)
  * [Authors and acknowledgment](#authors-and-acknowledgment)
  * [License](#license)
  * [Project status](#project-status)
<!-- TOC -->

# Overview
This package provide an easy way to integrate FiskalPay payment gateway using OOP structure.

You can make payment by install this library, provide necessary data, and just make request. Request will return a response with redirect url.

After processing the payment, the payment gateway will redirect to given link, and notified you by provided web hook

# Request
- Before implementing this package, you will need to make a request for license
- You will get credentials needed to fully function of this package.

# Installation

There are two ways of installing this package.

1. If you have access to read this repository on gitlab use this [tutorial](#install-using-composer)
2. In the other way you just download this package, and use require statement to include in your php script.

## Install using composer
- **Important! This guide can be used only in case you have read permissons on this git repository.**
1. [Download composer](https://getcomposer.org/download/)
2. Create your own composer.json
3. Add repository your composer.json
```json lines
//composer.json
{
  "repositories":[
    {
      "type":"composer",
      "url":"https://gitlab.a3soft.eu/api/v4/group/171/-/packages/composer/packages.json"
    }
  ]
}
```
4. Create file called `auth.json` and write the credentials there
```json lines
//auth.json
{
  "http-basic": {
    "gitlab.a3soft.eu": {
      "username": "__token__",
      "password": "YOUR_AUTH_TOKEN"
    }
  }
}
```
5. Run command `composer require a3soft/a3pay-php-client`.
This command will automatically install the newest version of A3 Pay client using credentials passed to `auth.json` file.
## Getting started

### Package classes

#### Request
- [Basket](./src/docs/Basket.md)
- [BasketHeader](/src/Helper/PaymentGatewayApi/Request/Basket.php)
- [BasketItem](/src/Helper/PaymentGatewayApi/Request/Basket.php)
- [CardHolder](/src/Helper/PaymentGatewayApi/Request/Basket.php)
- [CardHolderPhoneNumber](/src/Helper/PaymentGatewayApi/Request/Basket.php)
- [CustomerBasket](/src/Helper/PaymentGatewayApi/Request/Basket.php)
- [DanubePay](/src/Helper/PaymentGatewayApi/Request/Basket.php)
- [Payment](/src/Helper/PaymentGatewayApi/Request/Basket.php)
- [PaymentInfoRequest](/src/Helper/PaymentGatewayApi/Request/Basket.php)
#### Response 
- [CurlResponse](/src/Helper/PaymentGatewayApi/Response/CurlResponse.php)
- [PaymentInfoResponse](/src/Helper/PaymentGatewayApi/Response/PaymentInfoResponse.php)
- [PaymentResponse](/src/Helper/PaymentGatewayApi/Response/PaymentResponse.php)
#### Requester
- [PaymentGatewayRequester](src/PaymentGatewayApi/PaymentGatewayRequester.php)

#### Exceptions
- [CurlRequestException](/src/Exception/CurlRequestException.php)
- [VariableLengthException](/src/Exception/VariableLengthException.php)
- [VariableNotContainsException](/src/Exception/VariableNotContainsException.php)
- [VariableNotGuidException](/src/Exception/VariableNotGuidException.php)
- [VariableNotUrlException](/src/Exception/VariableNotUrlException.php)

#### Utils
- [AbstractToArray](/src/Util/AbstractToArray.php)
- [Utils](/src/Util/Utils.php)
