<?php

namespace MyHammer\Api\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MyHammer\Api\Entity\Service;
use MyHammer\Api\Repository\ServiceRepositoryInterface;

/**
 * Class ServiceService
 * @package MyHammer\Api\Service
 */
class ServiceService implements ServiceServiceInterface
{
    /** @var ServiceRepositoryInterface */
    private $serviceRepository;

    /**
     * ServiceService constructor.
     * @param ServiceRepositoryInterface $serviceRepository
     */
    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function find(?int $id): Service
    {
        return $this->serviceRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): ArrayCollection
    {
        return $this->serviceRepository->findAll();
    }
}
