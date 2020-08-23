<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Auth\SignUp\Email\Request;

class Command
{
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
}
