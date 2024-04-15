<?php
declare(strict_types=1);

namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request;

final class PaymentReferenceType
{
    /** @var string default, direct link to payment */
    const Direct = "Direct";
    /** @var string deferred link */
    const Email = "Email";
    /** @var string test the payment and validity.
    Payment will not be deposited. */
    const Test = "Test";
}