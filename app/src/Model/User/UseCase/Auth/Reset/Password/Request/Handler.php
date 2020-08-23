<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Auth\Reset\Password\Request;

use App\Doctrine\Dbal\Type\Email;
use App\Model\Flusher;
use App\Model\User\Entity\UserRepository;
use App\Model\User\Service\ResetPasswordTokenizer;
use App\Model\User\Service\ResetPasswordTokenSender;

class Handler
{
    private UserRepository $repository;
    private ResetPasswordTokenizer $tokenizer;
    private Flusher $flusher;
    private ResetPasswordTokenSender $sender;

    public function __construct(
        UserRepository $repository,
        ResetPasswordTokenizer $tokenizer,
        Flusher $flusher,
        ResetPasswordTokenSender $sender
    ) {
        $this->repository = $repository;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }

    public function handle(Command $command) : void
    {
        $email = new Email($command->email);
        $user = $this->repository->getByEmail($email);

        $token = $user->requestPasswordReset($this->tokenizer->generate(), new \DateTimeImmutable());
        $this->flusher->flush();

        $this->sender->send($email, $token);
    }
}
