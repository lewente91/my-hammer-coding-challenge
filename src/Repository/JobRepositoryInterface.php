<?php

namespace MyHammer\Api\Repository;

use MyHammer\Api\Entity\Job;

/**
 * Interface JobRepositoryInterface
 * @package MyHammer\Api\Repository
 */
interface JobRepositoryInterface
{
    /**
     * @param Job $job
     */
    public function save(Job $job): void;
}
