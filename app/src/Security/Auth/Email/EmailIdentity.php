<?php

declare(strict_types=1);

namespace App\Security\Auth\Email;

use App\Security\Auth\UserIdentity;

class EmailIdentity extends UserIdentity
{
    private string $email;

    public function __construct(
        string $id,
        string $email,
        string $password,
        ? string $role,
        string $status
    ) {
        parent::__construct($id, $password, $role, $status);
        $this->email = $email;
    }

    public function getUsername() : string
    {
        return $this->email;
    }
}
