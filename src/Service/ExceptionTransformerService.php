<?php

namespace MyHammer\Api\Service;

/**
 * Class ExceptionTransformerService
 * @package MyHammer\Api\Service
 */
class ExceptionTransformerService implements ExceptionTransformerServiceInterface
{
    /** @var array */
    private $exceptionMap;

    /**
     * ExceptionTransformerService constructor.
     * @param array $exceptionMap
     */
    public function __construct(array $exceptionMap)
    {
        $this->exceptionMap = $exceptionMap;
    }

    /**
     * {@inheritdoc}
     */
    public function transform(string $exceptionClass): string
    {
        $myHammerApiException = $this->exceptionMap['my_hammer_api_exception_map'][$exceptionClass] ?? null;
        if (null === $myHammerApiException) {
            throw new \RuntimeException(
                sprintf('Exception `%s` cannot be found under `my_hammer_api_exception_map`', $exceptionClass)
            );
        }

        $basicException = $this->exceptionMap['basic_exception_map'][$myHammerApiException] ?? null;
        if (null === $basicException) {
            throw new \RuntimeException(
                sprintf('Exception `%s` cannot be found under `basic_exception_map`', $basicException)
            );
        }

        return $basicException;
    }
}
