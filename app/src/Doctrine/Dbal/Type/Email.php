<?php

declare(strict_types=1);

namespace App\Doctrine\Dbal\Type;

use Webmozart\Assert\Assert;

class Email
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value, "email can't be empty");
        $address = filter_var($value, FILTER_VALIDATE_EMAIL);
        if (false === $address) {
            throw new \InvalidArgumentException('incorrect email.');
        }
        $this->value = mb_strtolower($value);
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public function isEqual(self $other) : bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function __toString()
    {
        return $this->value;
    }
}
