<?php

namespace MyHammer\Api\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use MyHammer\Api\Entity\Service;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Class ServiceRepository
 * @package MyHammer\Api\Repository
 */
class ServiceRepository implements ServiceRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EntityRepository */
    private $repository;

    /**
     * ServiceRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Service::class);
    }

    /**
     * {@inheritdoc}
     */
    public function find(int $id): Service
    {
        $service = $this->repository->find($id);
        if (!$service instanceof Service) {
            throw new EntityNotFoundException(
                sprintf('Service `%d` was not found', $service)
            );
        }

        return $service;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): ArrayCollection
    {
        return new ArrayCollection($this->repository->findAll());
    }
}
