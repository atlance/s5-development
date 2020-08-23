<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Auth\SignUp\Email\Request;

use App\Doctrine\Dbal\Type\Email;
use App\Model\Flusher;
use App\Model\User\Entity\Id;
use App\Model\User\Entity\Name;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserRepository;
use App\Model\User\Service\PasswordHasher;
use App\Model\User\Service\SignUpConfirmEmailTokenSender;
use App\Model\User\Service\SignUpConfirmTokenizer;
use App\ReadModel\User\UserFetcher;
use RuntimeException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class Handler
{
    private UserFetcher $fetcher;
    private UserRepository $repository;
    private PasswordHasher $hasher;
    private SignUpConfirmEmailTokenSender $sender;
    private SignUpConfirmTokenizer $tokenizer;
    private Flusher $flusher;

    public function __construct(
        UserFetcher $fetcher,
        UserRepository $repository,
        PasswordHasher $hasher,
        SignUpConfirmEmailTokenSender $sender,
        SignUpConfirmTokenizer $tokenizer,
        Flusher $flusher
    ) {
        $this->fetcher = $fetcher;
        $this->hasher = $hasher;
        $this->sender = $sender;
        $this->tokenizer = $tokenizer;
        $this->repository = $repository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command) : void
    {
        $email = new Email($command->email);

        if ($this->fetcher->hasByEmail($email)) {
            throw new \DomainException('User already exists.');
        }

        $user = User::signUpByEmail(
            Id::generate(),
            new Name($command->firstName, $command->lastName),
            $email,
            new \DateTimeImmutable(),
            $token = $this->tokenizer->generate(),
            $this->hasher->hash($command->password)
        );

        $this->repository->add($user);

        try {
            $this->sender->send($email, $token);
            $this->flusher->flush();
        } catch (TransportExceptionInterface $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}
