<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Auth\SignUp\Email\Confirm;

use App\Model\Flusher;
use App\Model\User\Entity\UserRepository;

class Handler
{
    private UserRepository $repository;
    private Flusher $flusher;

    public function __construct(UserRepository $repository, Flusher $flusher)
    {
        $this->repository = $repository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command) : void
    {
        $user = $this->repository->findByConfirmToken($command->token);
        if (null === $user) {
            throw new \DomainException('Incorrect or confirmed token.');
        }

        $user->confirmSignUp();
        $this->flusher->flush();
    }
}
