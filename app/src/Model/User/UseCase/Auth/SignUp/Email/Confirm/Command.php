<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Auth\SignUp\Email\Confirm;

class Command
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
