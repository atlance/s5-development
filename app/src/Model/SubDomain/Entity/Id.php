<?php

declare(strict_types=1);

namespace App\Model\SubDomain\Entity;

use Webmozart\Assert\Assert;

class Id
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::alnum($value);
        Assert::maxLength($value, 16);
        $this->value = $value;
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
