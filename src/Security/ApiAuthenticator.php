<?php

namespace MyHammer\Api\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

/**
 * Class ApiAuthenticator
 * @package MyHammer\Api\Security
 */
class ApiAuthenticator implements SimplePreAuthenticatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function authenticateToken(
        TokenInterface $token,
        UserProviderInterface $userProvider,
        $providerKey
    ): TokenInterface {
        $user = $userProvider->loadUserByUsername('levente.molnar91');

        return new PreAuthenticatedToken(
            $user,
            $token->getCredentials(),
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsToken(TokenInterface $token, $providerKey): bool
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * {@inheritdoc}
     */
    public function createToken(Request $request, $providerKey): TokenInterface
    {
        // Return dummy anonymous token
        return new PreAuthenticatedToken('anonymous', 'apiKey', $providerKey);
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new Response(
            strtr($exception->getMessageKey(), $exception->getMessageData()),
            Response::HTTP_UNAUTHORIZED
        );
    }
}
