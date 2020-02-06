<?php

namespace Soljian\SteamAuthenticationBundle\Security\Authentication\Provider;

use Soljian\SteamAuthenticationBundle\Security\Authentication\Token\SteamUserToken;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Soljian
 */
class SteamProvider implements AuthenticationProviderInterface
{
    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @param UserProviderInterface $userProvider
     */
    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByUsername($token->getUsername());

        $authenticatedToken = new SteamUserToken();
        $authenticatedToken->setUser($user);
        $authenticatedToken->setUsername($user->getUsername());
        $authenticatedToken->setAuthenticated(true);

        return $authenticatedToken;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof SteamUserToken;
    }
}