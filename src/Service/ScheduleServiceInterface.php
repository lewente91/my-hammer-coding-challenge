<?php

namespace MyHammer\Api\Service;

use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Interface ScheduleServiceInterface
 * @package MyHammer\Api\Service
 */
interface ScheduleServiceInterface
{
    /**
     * @param string $schedule
     * @return string
     * @throws EntityNotFoundException
     */
    public function find(string $schedule): string;

    /**
     * @return array
     */
    public function findAll(): array;
}
