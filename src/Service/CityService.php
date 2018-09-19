<?php

namespace MyHammer\Api\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MyHammer\Api\Entity\City;
use MyHammer\Api\Repository\CityRepositoryInterface;

/**
 * Class CityService
 * @package MyHammer\Api\Service
 */
class CityService implements CityServiceInterface
{
    /** @var CityRepositoryInterface */
    private $cityRepository;

    /**
     * CityService constructor.
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $zip): City
    {
        return $this->cityRepository->find($zip);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): ArrayCollection
    {
        return $this->cityRepository->findAll();
    }
}
