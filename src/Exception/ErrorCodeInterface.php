<?php

namespace MyHammer\Api\Exception;

/**
 * Interface ErrorCodeInterface
 * @package MyHammer\Api\Exception
 */
interface ErrorCodeInterface
{
    /**
     * @return string
     */
    public function getErrorCode(): string;
}
