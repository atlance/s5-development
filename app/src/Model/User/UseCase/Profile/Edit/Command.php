<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Profile\Edit;

use App\Model\User\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     */
    public string $id;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    public string $email;
    public ? string $password;
    /**
     * @Assert\NotBlank
     */
    public string $firstName;
    /**
     * @Assert\NotBlank
     */
    public string $lastName;

    public static function fromUser(User $user) : self
    {
        $command = new self();
        $command->id = (string)$user->getId();
        $command->email = (string)$user->getEmail();
        $command->firstName = $user->getName()->getFirst();
        $command->lastName = $user->getName()->getLast();
        $command->password = null;

        return $command;
    }
}
