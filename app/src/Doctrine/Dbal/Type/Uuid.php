<?php

declare(strict_types=1);

namespace App\Doctrine\Dbal\Type;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Webmozart\Assert\Assert;

class Uuid
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::true(RamseyUuid::isValid($value), 'Not valid UUID');
        $this->value = $value;
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public static function generate() : self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    public function __toString() : string
    {
        return $this->getValue();
    }
}
