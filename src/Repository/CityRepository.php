<?php

namespace MyHammer\Api\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use MyHammer\Api\Entity\City;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Class CityRepository
 * @package MyHammer\Api\Repository
 */
class CityRepository implements CityRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EntityRepository */
    private $repository;

    /**
     * CityRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(City::class);
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $zip): City
    {
        $city = $this->repository->find($zip);
        if (!$city instanceof City) {
            throw new EntityNotFoundException(
                sprintf('City with ZipCode `%s` was not found.', $zip)
            );
        }

        return $city;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): ArrayCollection
    {
        return new ArrayCollection($this->repository->findAll());
    }
}
