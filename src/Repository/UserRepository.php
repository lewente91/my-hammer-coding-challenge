<?php

namespace MyHammer\Api\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use MyHammer\Api\Entity\User;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Class UserRepository
 * @package MyHammer\Api\Repository
 */
class UserRepository implements UserRepositoryInterface
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
        $this->repository = $entityManager->getRepository(User::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findByUsername(string $username): User
    {
        $user = $this->repository->findOneBy(['username' => $username]);
        if (!$user instanceof User) {
            throw new EntityNotFoundException(
                sprintf('User by username `%s` not found', $username)
            );
        }

        return $user;
    }
}
