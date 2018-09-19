<?php

namespace MyHammer\Api\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use MyHammer\Api\Entity\Service;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Interface ServiceRepositoryInterface
 * @package MyHammer\Api\Repository
 */
interface ServiceRepositoryInterface
{
    /**
     * @param int $id
     * @return Service
     * @throws EntityNotFoundException
     */
    public function find(int $id): Service;

    /**
     * @return ArrayCollection
     */
    public function findAll(): ArrayCollection;
}
