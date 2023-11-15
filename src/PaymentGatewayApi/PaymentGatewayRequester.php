<?php
declare(strict_types=1);

namespace A3Soft\A3PayPhpClient\PaymentGatewayApi;

use A3Soft\A3PayPhpClient\Exception\CurlRequestException;
use A3Soft\A3PayPhpClient\Exception\VariableNotUrlException;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Request\PaymentGatewayRequest;
use A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response\CurlResponse;
use A3Soft\A3PayPhpClient\Util\Utils;

/**
 * PaymentGatewayRequester service, which ensures requests and response to FiskalPay API
 * @example ExamplePaymentRequest.php example use of payment gateway requester
 * @package Service
 */
final class PaymentGatewayRequester
{

    /** @var string Link that request will be submitted to */
    private string $link;
    /** @var string Secret token used in header of request. */
    private string $token;

    /**
     * @param string $link Link that request will be submitted to
     * @param string $token Secret token used in header of request.
     * @throws VariableNotUrlException
     */
    public function __construct(
        string $link,
        string $token
    )
    {
        Utils::checkValueUrl($link, 'link');
        $this->link = $link;
        $this->token = htmlspecialchars($token);
    }

    /**
     * Makes request to FiskalPay api
     * @param array|PaymentGatewayRequest $paymentGatewayRequest array data, or object implementing PaymentGatewayRequest interface that will be submitted to api
     * @return CurlResponse
     * @throws CurlRequestException
     */
    public function makeRequest($paymentGatewayRequest): CurlResponse
    {
        if(is_array($paymentGatewayRequest)) {
            /** @var array $data */
            $data = $paymentGatewayRequest;
        } else {
            $data = $paymentGatewayRequest->toArray(true, true, true);
        }

        return $this->sendPostRequest($this->link, $data, $this->token);
    }

    /**
     * @param string $url
     * @param array $jsonData
     * @param string $accessToken
     * @return CurlResponse
     * @throws CurlRequestException
     */
    private function sendPostRequest(string $url, array $jsonData, string $accessToken): CurlResponse {
        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken,
        ];

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($jsonData),
            CURLOPT_HTTPHEADER => $headers,
        ];

        curl_setopt_array($ch, $options);

        // Execute cURL session and get the response

        $response = curl_exec($ch);
        $curlResponse = new CurlResponse();

        if($response)
            $curlResponse->setBody($response);
        $curlResponse->setStatusCode((int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE));
        // Check for cURL errors
        if (curl_errno($ch)) {
            $curlResponse->setErrorMessage(curl_error($ch));
            curl_close($ch);
            throw new CurlRequestException($curlResponse->getErrorMessage(), $curlResponse);
        }

        // Close cURL session
        curl_close($ch);

        // Return the response
        return $curlResponse;
    }
}