<?php

declare(strict_types=1);

namespace App\Utils\Http\Factory;

class SubDomain
{
    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
