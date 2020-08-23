<?php

declare(strict_types=1);

namespace App\Security\Auth;

interface IdentityInterface
{
    public function getId() : string;
}
