<?php

namespace MyHammer\Api\Exception;

use RuntimeException;

/**
 * Class AbstractApiException
 * @package MyHammer\Api\Exception
 */
abstract class AbstractApiException extends RuntimeException implements ErrorCodeInterface
{
    /** @var string */
    protected $errorCode = 'INTERNAL_SERVER_ERROR';

    /**
     * {@inheritdoc}
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
