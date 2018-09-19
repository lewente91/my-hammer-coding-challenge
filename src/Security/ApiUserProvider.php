<?php

namespace MyHammer\Api\Security;

use MyHammer\Api\Entity\User;
use MyHammer\Api\Exception\EntityNotFoundException;
use MyHammer\Api\Service\UserServiceInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class ApiUserProvider
 * @package MyHammer\Api\Security
 */
class ApiUserProvider implements UserProviderInterface
{
    /** @var UserServiceInterface */
    private $userService;

    /**
     * ApiUserProvider constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username): UserInterface
    {
        try {
            $user = $this->userService->findByUsername($username);
        } catch (EntityNotFoundException $exception) {
            $user = null;
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        // Refresh user is not supported, since we are using a stateless authentication
        throw new UnsupportedUserException();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}
