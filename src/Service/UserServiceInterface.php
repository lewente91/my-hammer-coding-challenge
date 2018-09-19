<?php

namespace MyHammer\Api\Service;

use MyHammer\Api\Entity\User;
use MyHammer\Api\Exception\EntityNotFoundException;

/**
 * Interface UserServiceInterface
 * @package MyHammer\Api\Service
 */
interface UserServiceInterface
{
    /**
     * @param string $username
     * @return User
     * @throws EntityNotFoundException
     */
    public function findByUsername(string $username): User;
}
