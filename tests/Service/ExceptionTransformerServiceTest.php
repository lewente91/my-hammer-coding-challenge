<?php

namespace MyHammer\Api\Tests\Service;

use MyHammer\Api\Exception\ConstraintViolationException;
use MyHammer\Api\Exception\EntityNotFoundException;
use MyHammer\Api\Service\ExceptionTransformerService;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Class ExceptionTransformerServiceTest
 * @package MyHammer\Api\Tests\Service
 */
class ExceptionTransformerServiceTest extends TestCase
{
    /**
     * @return array
     */
    public function exceptionMapProvider(): array
    {
        return [
            'Working exception map configuration' => [
                'Basic exception map' => [
                    'basic_exception_map' => [
                        'NotFoundHttpException' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException'
                    ],
                    'my_hammer_api_exception_map' => [
                        'MyHammer\Api\Exception\EntityNotFoundException' => 'NotFoundHttpException'
                    ]
                ],
                'Tested exception' => EntityNotFoundException::class,
                'Expect exception' => false
            ],
            'Tested exception cannot be found in api exception map' => [
                'Basic exception map' => [
                    'basic_exception_map' => [
                        'NotFoundHttpException' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException'
                    ],
                    'my_hammer_api_exception_map' => [
                        'MyHammer\Api\Exception\EntityNotFoundException' => 'NotFoundHttpException'
                    ]
                ],
                'Tested exception' => ConstraintViolationException::class,
                'Expect exception' => true
            ],
            'Tested exception cannot be found in basic exception map' => [
                'Basic exception map' => [
                    'basic_exception_map' => [
                        'BadRequestHttpException' => 'Symfony\Component\HttpKernel\Exception\BadRequestHttpException'
                    ],
                    'my_hammer_api_exception_map' => [
                        'MyHammer\Api\Exception\EntityNotFoundException' => 'NotFoundHttpException'
                    ]
                ],
                'Tested exception' => EntityNotFoundException::class,
                'Expect exception' => true
            ]
        ];
    }

    /**
     * Test instance
     */
    public function testInstance(): void
    {
        $exceptionTransformerService = new ExceptionTransformerService(
            [
                'basic_exception_map' => [
                    'NotFoundHttpException' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException'
                ],
                'my_hammer_api_exception_map' => [
                    'MyHammer\Api\Exception\EntityNotFoundException' => 'NotFoundHttpException'
                ]
            ]
        );

        self::assertInstanceOf(ExceptionTransformerService::class, $exceptionTransformerService);
    }

    /**
     * @dataProvider exceptionMapProvider
     *
     * @param array $exceptionMap
     * @param string $testedException
     * @param bool $expectException
     */
    public function testTransform(array $exceptionMap, string $testedException, bool $expectException): void
    {
        if (true === $expectException) {
            self::expectException(RuntimeException::class);
        }
        $exceptionTransformerService = new ExceptionTransformerService($exceptionMap);
        $result = $exceptionTransformerService->transform($testedException);
        if (false === $expectException) {
            self::assertInternalType('string', $result);
        }
    }
}
