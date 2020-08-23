<?php

declare(strict_types=1);

namespace App\Security\Auth\Email;

use App\ReadModel\User\Auth\AuthView;
use App\ReadModel\User\UserFetcher;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Provider implements UserProviderInterface
{
    private UserFetcher $fetcher;

    public function __construct(UserFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    public function loadUserByUsername(string $email) : EmailIdentity
    {
        $user = $this->loadUser($email);

        return self::identityByUser($user);
    }

    public function refreshUser(UserInterface $identity) : EmailIdentity
    {
        if (!$identity instanceof EmailIdentity) {
            throw new UnsupportedUserException('Invalid user class ' . \get_class($identity));
        }

        $user = $this->loadUser($identity->getUsername());

        return self::identityByUser($user);
    }

    public function supportsClass(string $class) : bool
    {
        return EmailIdentity::class === $class;
    }

    private function loadUser(string $email) : AuthView
    {
        if (($user = $this->fetcher->findByEmail($email)) instanceof AuthView) {
            return $user;
        }

        throw new UsernameNotFoundException('');
    }

    private static function identityByUser(AuthView $user) : EmailIdentity
    {
        return new EmailIdentity(
            $user->id,
            $user->email,
            $user->password_hash,
            $user->role,
            $user->status
        );
    }
}
