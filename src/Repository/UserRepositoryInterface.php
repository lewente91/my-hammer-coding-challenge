<?php

namespace MyHammer\Api\Repository;

use MyHammer\Api\Entity\User;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Interface UserRepositoryInterface
 * @package MyHammer\Api\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @param string $username
     * @return User
     * @throws EntityNotFoundException
     */
    public function findByUsername(string $username): User;
}
