<?php

namespace MyHammer\Api\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MyHammer\Api\Entity\City;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Interface CityServiceInterface
 * @package MyHammer\Api\Service
 */
interface CityServiceInterface
{
    /**
     * @param string $zip
     * @return City
     * @throws EntityNotFoundException
     */
    public function find(string $zip): City;

    /**
     * @return ArrayCollection
     */
    public function findAll(): ArrayCollection;
}
