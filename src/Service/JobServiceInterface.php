<?php

namespace MyHammer\Api\Service;

use MyHammer\Api\Entity\Job;

/**
 * Interface JobServiceInterface
 * @package MyHammer\Api\Service
 */
interface JobServiceInterface
{
    /**
     * @param Job $job
     */
    public function create(Job $job): void;
}
