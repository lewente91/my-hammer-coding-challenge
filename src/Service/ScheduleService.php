<?php

namespace MyHammer\Api\Service;

use MyHammer\Api\Entity\Schedule;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Class ScheduleService
 * @package MyHammer\Api\Service
 */
class ScheduleService implements ScheduleServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function find(string $schedule): string
    {
        if (in_array($schedule, Schedule::VALUES)) {
            return $schedule;
        }

        throw new EntityNotFoundException(
            sprintf('Schedule `%s` was not found', $schedule)
        );
    }
    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return Schedule::VALUES;
    }
}
