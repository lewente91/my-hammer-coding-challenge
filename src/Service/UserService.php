<?php

namespace MyHammer\Api\Service;

use MyHammer\Api\Entity\User;
use MyHammer\Api\Repository\UserRepositoryInterface;

/**
 * Class UserService
 * @package MyHammer\Api\Service
 */
class UserService implements UserServiceInterface
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUsername(string $username): User
    {
        return $this->userRepository->findByUsername($username);
    }
}
