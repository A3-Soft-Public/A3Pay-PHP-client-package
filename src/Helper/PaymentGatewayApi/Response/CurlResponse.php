<?php

namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response;

use JsonException;

class CurlResponse
{
    /** @var string|null  */
    private ?string $body = null;
    /** @var int|null  */
    private ?int $statusCode = null;
    /** @var string|null  */
    private ?string $errorMessage;

    public function __construct()
    {
    }


    /**
     * Convert response body to json, on error throw @link JsonExcepiton
     * @throws JsonException
     * @return array
     */
    public function json(): array
    {
       return json_decode($this->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Return response body
     * @return string
     */
    public function getBody(): string
    {
        return $this->body ?? '';
    }

    /**
     * Return status code from response
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode ?? 0;
    }

    /**
     * Return error message if any. Else return null
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * Return if response has error
     * @return bool
     */
    public function hasErrorMessage(): bool {
        return $this->errorMessage !== null;
    }

    /**
     * Set response body
     * @param string|null $body
     * @return $this
     */
    public function setBody(?string $body): CurlResponse
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Set response status code
     * @param int|null $statusCode
     * @return $this
     */
    public function setStatusCode(?int $statusCode): CurlResponse
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Set response error message
     * @param string|null $errorMessage
     * @return $this
     */
    public function setErrorMessage(?string $errorMessage): CurlResponse
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

}