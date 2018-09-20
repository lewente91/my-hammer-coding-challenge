<?php

namespace MyHammer\Api\Tests\Service;

use MyHammer\Api\Exception\EntityNotFoundException;
use MyHammer\Api\Service\ScheduleService;
use PHPUnit\Framework\TestCase;

/**
 * Class ScheduleServiceTest
 * @package MyHammer\Api\Tests\Service
 */
class ScheduleServiceTest extends TestCase
{
    const TEST_SCHEDULE_SUCCESS = 'ASAP';
    const TEST_SCHEDULE_FAILURE = 'yesterday';

    /**
     * Test find success
     */
    public function testFindSuccess(): void
    {
        $scheduleService = new ScheduleService();
        $result = $scheduleService->find(self::TEST_SCHEDULE_SUCCESS);

        self::assertEquals(self::TEST_SCHEDULE_SUCCESS, $result);
    }

    /**
     * Test find failure
     */
    public function testFindFailure(): void
    {
        self::expectException(EntityNotFoundException::class);

        $scheduleService = new ScheduleService();
        $scheduleService->find(self::TEST_SCHEDULE_FAILURE);
    }

    /**
     * Test find all
     */
    public function testFindAll(): void
    {
        $scheduleService = new ScheduleService();
        $result = $scheduleService->findAll();

        self::assertInternalType('array', $result);
    }
}
