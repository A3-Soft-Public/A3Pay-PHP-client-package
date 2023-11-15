<?php
declare(strict_types=1);

namespace A3Soft\A3PayPhpClient\Helper\PaymentGatewayApi\Response;

use A3Soft\A3PayPhpClient\Util\AbstractToArray;
use Exception;

/**
 * Represents payment info response data model
 * @package DataModel
 */
class PaymentInfoResponse extends AbstractToArray
{
    const StatusCreated = 'Created';
    const StatusNew = 'New';
    const StatusAuthorized = 'Authorized';
    const StatusDeclined = 'Declined';
    const StatusReversed = 'Reversed';
    const StatusCaptured = 'Captured';
    const StatusError = 'Error';

    const Statuses = [
      self::StatusCreated,
      self::StatusNew,
      self::StatusAuthorized,
      self::StatusDeclined,
      self::StatusReversed,
      self::StatusCaptured,
      self::StatusError,
    ];
    private string $status;
    private ?string $errorMessage;

    /**
     * @param string $status Merchant payment status. Available values :<br>
     *  Created<br>
     *  Processing<br>
     *  Authenticated<br>
     *  Done<br>
     *  Error
     * @param string|null $errorMessage Error message if exists.
     * @throws Exception
     */
    public function __construct(
        string  $status,
        ?string $errorMessage = null
    )
    {
        $this->checkStatus($status);
        $this->status = $status;
        $this->errorMessage = $errorMessage;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }


    /**
     * @throws Exception
     */
    public function checkStatus($status)
    {
        switch ($status) {
            case self::StatusCreated:
            case self::StatusNew:
            case self::StatusAuthorized:
            case self::StatusDeclined:
            case self::StatusReversed:
            case self::StatusCaptured:
            case self::StatusError:
            {
                break;
            }
            default: {
                throw new Exception("Unknown status \"$status\" passed in constructor!");
            }
        }
    }

    /**
     * Create @param array $responseArray
     * @return self
     * @throws Exception
     * PaymentInfoResponse from array
     */
    public static function fromArray(array $responseArray): self
    {
        if (!array_key_exists('status', $responseArray)) {
            throw new Exception('Array key \"status\" missing in response data!');
        }
        if (!array_key_exists('errorMessage', $responseArray)) {
            $responseArray['errorMessage'] = null;
        }
        if (gettype($responseArray['status']) !== 'string') {
            throw new Exception('Array key \"status\" type does not match string type!');
        }

        if ($responseArray['errorMessage'] !== null && gettype($responseArray['errorMessage']) !== 'string') {
            throw new Exception('Array key \"errorMessage\" type does not match string type!');
        }
        return new PaymentInfoResponse($responseArray['status'], $responseArray['errorMessage']);
    }

}