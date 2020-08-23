<?php

declare(strict_types=1);

namespace App\Security\Auth;

use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class UserIdentity implements IdentityInterface, StatusInterface, UserInterface, EquatableInterface
{
    protected string $id;
    protected string $password;
    protected ? string $role;
    protected string $status;

    public function __construct(
        string $id,
        string $password,
        ? string $role,
        string $status
    ) {
        $this->id = $id;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getStatus() : string
    {
        return $this->status;
    }

    abstract public function getUsername();

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getRoles() : array
    {
        if (\is_string($this->role)) {
            return [$this->role];
        }

        return [];
    }

    public function getSalt() : ? string
    {
        return null;
    }

    public function eraseCredentials() : void
    {
    }

    public function isEqualTo(UserInterface $user) : bool
    {
        if (!$user instanceof self) {
            return false;
        }

        return
            $this->id === $user->id &&
            $this->password === $user->password &&
            $this->role === $user->role &&
            $this->status === $user->status;
    }
}
