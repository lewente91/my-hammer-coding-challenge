<?php

namespace MyHammer\Api\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MyHammer\Api\Entity\Service;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Interface ServiceServiceInterface
 * @package MyHammer\Api\Service
 */
interface ServiceServiceInterface
{
    /**
     * @param int|null $id
     * @return Service
     * @throws EntityNotFoundException
     */
    public function find(?int $id): Service;

    /**
     * @return ArrayCollection
     */
    public function findAll(): ArrayCollection;
}
