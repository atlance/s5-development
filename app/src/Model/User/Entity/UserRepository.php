<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use App\Doctrine\Dbal\Type\Email;
use App\Doctrine\Dbal\Type\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UserRepository
{
    private EntityManagerInterface $em;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(User::class);
    }

    public function add(User $user) : void
    {
        $this->em->persist($user);
    }

    public function get(Uuid $id) : User
    {
        $user = $this->repository->find($id);
        if ($user instanceof User) {
            return $user;
        }

        throw new \DomainException("User by id: {$id->getValue()} - not found");
    }

    public function findByConfirmToken(string $token) : ? User
    {
        $user = $this->repository->findOneBy(['confirmToken' => $token]);

        if ($user instanceof User) {
            return $user;
        }

        return null;
    }

    public function findByResetPasswordToken(string $token) : ? User
    {
        $user = $this->repository->findOneBy(['resetPasswordToken.token' => $token]);

        if ($user instanceof User) {
            return $user;
        }

        return null;
    }

    public function getByEmail(Email $email) : User
    {
        $user = $this->repository->findOneBy(['email' => $email->getValue()]);

        if ($user instanceof User) {
            return $user;
        }

        throw new \DomainException("User by email: {$email->getValue()} - not found");
    }
}
