<?php

declare(strict_types=1);

namespace App\ReadModel\User\Auth;

use App\ReadModel\AbstractView;

class AuthView extends AbstractView
{
    public string $id;
    public string $email;
    public string $password_hash;
    public string $status;
    public ? string $role;
}
