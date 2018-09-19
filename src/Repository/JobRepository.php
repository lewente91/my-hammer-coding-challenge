<?php

namespace MyHammer\Api\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use MyHammer\Api\Entity\Job;

/**
 * Class JobRepository
 * @package MyHammer\Api\Repository
 */
class JobRepository implements JobRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EntityRepository */
    private $repository;

    /**
     * JobRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Job::class);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Job $job): void
    {
        $this->entityManager->persist($job);
        $this->entityManager->flush();
    }
}
