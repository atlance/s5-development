<?php

declare(strict_types=1);

namespace App\ReadModel\User;

use App\Doctrine\Dbal\Type\Email;
use App\Doctrine\Dbal\Type\Uuid;
use App\ReadModel\Fetcher;
use App\ReadModel\User\Auth\AuthView;
use Doctrine\DBAL\FetchMode;

class UserFetcher extends Fetcher
{
    public function findByEmail(string $email) : ? AuthView
    {
        $qb = $this->getQueryBuilder()
            ->select(['id', 'email', 'password_hash', 'status', 'role'])
            ->from('users', 'u')
            ->where('u.email = :email')
            ->setParameter(':email', $email);

        $result = $this->getResultStatement($qb, FetchMode::CUSTOM_OBJECT, AuthView::class)->fetch();

        if (false !== $result) {
            return $result;
        }

        return null;
    }

    public function findByConfirmToken(string $token) : ? AuthView
    {
        $qb = $this->getQueryBuilder()
            ->select(['id', 'email', 'password_hash', 'status', 'role'])
            ->from('users', 'u')
            ->where('u.confirm_token = :token')
            ->setParameter(':token', $token);

        $result = $this->getResultStatement($qb, FetchMode::CUSTOM_OBJECT, AuthView::class)
            ->fetch();

        if (false !== $result) {
            return $result;
        }

        return null;
    }

    public function findByResetToken(string $token) : ? AuthView
    {
        $qb = $this->getQueryBuilder()
            ->select(['id', 'email', 'password_hash', 'status', 'role'])
            ->from('users', 'u')
            ->where('u.reset_password_token = :token')
            ->setParameter(':token', $token);

        $result = $this->getResultStatement($qb, FetchMode::CUSTOM_OBJECT, AuthView::class)
            ->fetch();

        if (false !== $result) {
            return $result;
        }

        return null;
    }

    public function hasByEmail(Email $email) : bool
    {
        $qb = $this->getQueryBuilder()
            ->select(['COUNT(u.id)'])
            ->from('users', 'u')
            ->where('u.email = :email')
            ->setParameter(':email', $email);

        $stmt = $this->getResultStatement($qb, FetchMode::COLUMN, 0);

        return (int)$stmt->fetch() > 0;
    }

    public function getByEmail(Email $email) : AuthView
    {
        $qb = $this->getQueryBuilder()
            ->select(['id', 'email', 'password_hash', 'status', 'role'])
            ->from('users', 'u')
            ->where('u.email = :email')
            ->setParameter(':email', $email);

        $user = $this->getResultStatement($qb, FetchMode::CUSTOM_OBJECT, AuthView::class)->fetch();

        if ($user instanceof AuthView) {
            return $user;
        }

        throw new \DomainException("User by email: {$email->getValue()} - not found");
    }

    public function get(Uuid $id) : AuthView
    {
        $qb = $this->getQueryBuilder()
            ->select(['id', 'email', 'password_hash', 'status', 'role'])
            ->from('users', 'u')
            ->where('u.id = :id')
            ->setParameter(':id', $id);

        $user = $this->getResultStatement($qb, FetchMode::CUSTOM_OBJECT, AuthView::class)->fetch();

        if ($user instanceof AuthView) {
            return $user;
        }

        throw new \DomainException("User by id: {$id->getValue()} - not found");
    }
}
