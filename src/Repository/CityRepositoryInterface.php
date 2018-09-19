<?php

namespace MyHammer\Api\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use MyHammer\Api\Entity\City;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Interface CityRepositoryInterface
 * @package MyHammer\Api\Repository
 */
interface CityRepositoryInterface
{
    /**
     * @param string $zip
     * @return City|null
     * @throws EntityNotFoundException
     */
    public function find(string $zip): City;

    /**
     * @return ArrayCollection
     */
    public function findAll(): ArrayCollection;
}
