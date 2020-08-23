<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Id
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::true(Uuid::isValid($value), 'Not valid UUID');
        $this->value = $value;
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public static function generate() : self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function __toString() : string
    {
        return $this->getValue();
    }
}
