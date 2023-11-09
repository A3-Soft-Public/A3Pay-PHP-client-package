<?php

namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response;

use JsonException;

class CurlResponse
{
    private ?string $body = null;
    private ?int $statusCode = null;
    private ?string $errorMessage;

    public function __construct()
    {
    }


    /**
     * @throws JsonException
     * @return array
     */
    public function json(): array
    {
       return json_decode($this->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }


    public function hasErrorMessage(): bool {
        return $this->errorMessage !== null;
    }

    public function setBody(?string $body): CurlResponse
    {
        $this->body = $body;
        return $this;
    }

    public function setStatusCode(?int $statusCode): CurlResponse
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setErrorMessage(?string $errorMessage): CurlResponse
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

}