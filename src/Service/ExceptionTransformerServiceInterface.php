<?php

namespace MyHammer\Api\Service;

/**
 * Interface ExceptionTransformerServiceInterface
 * @package MyHammer\Api\Service
 */
interface ExceptionTransformerServiceInterface
{
    /**
     * @param string $exceptionClass
     * @return string
     */
    public function transform(string $exceptionClass): string;
}
