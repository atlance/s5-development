<?php

declare(strict_types=1);

namespace App\Security\Auth;

interface StatusInterface
{
    public function getStatus() : string;
}
