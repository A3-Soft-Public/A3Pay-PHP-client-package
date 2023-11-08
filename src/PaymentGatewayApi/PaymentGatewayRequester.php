<?php
declare(strict_types=1);

namespace A3Soft\A3PayPhpClientPackage\Service\PaymentGatewayApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

final class PaymentGatewayRequester
{

    private string $link;
    private string $token;

    /**
     * @param string $link Link that request will be submitted to
     * @param string $token Secret token used in header of request.
     */
    public function __construct(
        string $link,
        string $token
    )
    {

        $this->link = $link;
        $this->token = htmlspecialchars($token);
    }

    /**
     * @param $paymentGatewayRequest
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function makeRequest($paymentGatewayRequest): ResponseInterface
    {
        $client = new Client();
        if(is_array($paymentGatewayRequest)) {
            $data = $paymentGatewayRequest;
        } else {
            $data = $paymentGatewayRequest->toArray(true, true);
        }
        return $client->request(
            'POST',
            $this->link,
            [
                'json' => $data,
                'headers' => [
                    'Authorization' => "Bearer {$this->token}"
                ]
            ]
        );
    }
}