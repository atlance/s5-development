<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Profile\Edit;

use App\Doctrine\Dbal\Type\Email;
use App\Doctrine\Dbal\Type\Uuid;
use App\Model\Flusher;
use App\Model\User\Entity\Name;
use App\Model\User\Entity\UserRepository;
use App\Model\User\Service\PasswordHasher;

class Handler
{
    private UserRepository $repository;
    private PasswordHasher $hasher;
    private Flusher $flusher;

    public function __construct(UserRepository $repository, PasswordHasher $hasher, Flusher $flusher)
    {
        $this->repository = $repository;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    public function handle(Command $command) : void
    {
        $user = $this->repository->get(new Uuid($command->id));
        $user->editProfile(
            new Email($command->email),
            new Name($command->firstName, $command->lastName),
            null === $command->password ?
                $user->getPasswordHash() :
                $this->hasher->hash($command->password)
        );

        $this->flusher->flush();
    }
}
