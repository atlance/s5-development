<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Auth\SignIn\Email\Request;

class Command
{
    public string $email;
    public string $password;
}
