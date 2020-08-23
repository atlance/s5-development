<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Auth\Reset\Password\Confirm;

use App\Model\Flusher;
use App\Model\User\Entity\UserRepository;
use App\Model\User\Service\PasswordHasher;

class Handler
{
    private UserRepository $repository;
    private Flusher $flusher;
    private PasswordHasher $hasher;

    public function __construct(
        UserRepository $repository,
        Flusher $flusher,
        PasswordHasher $hasher
    ) {
        $this->repository = $repository;
        $this->flusher = $flusher;
        $this->hasher = $hasher;
    }

    public function handle(Command $command) : void
    {
        $user = $this->repository->findByResetPasswordToken($command->token);
        if (null === $user) {
            throw new \DomainException('Incorrect or confirmed reset token.');
        }

        $user->passwordReset(
            new \DateTimeImmutable(),
            $this->hasher->hash($command->password)
        );
        $this->flusher->flush();
    }
}
