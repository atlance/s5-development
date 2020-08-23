<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use Webmozart\Assert\Assert;

class Status
{
    public const STATUS_NEW = 'new';
    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';

    private const STATUSES = [
        'null' => null,
        'STATUS_NEW' => 'new',
        'STATUS_WAIT' => 'wait',
        'STATUS_ACTIVE' => 'active',
        'STATUS_BLOCKED' => 'blocked',
    ];

    private ? string $value;

    public function __construct(string $value = null)
    {
        Assert::oneOf($value, self::STATUSES, 'not allowed status');
        $this->value = $value;
    }

    public function setValue(string $value) : self
    {
        Assert::oneOf($value, self::STATUSES, 'not allowed status');
        $this->value = $value;

        return $this;
    }

    public function getValue() : ? string
    {
        return $this->value;
    }

    public function toWait() : self
    {
        $this->value = self::STATUS_WAIT;

        return $this;
    }

    public function isWait() : bool
    {
        return self::STATUS_WAIT === $this->value;
    }

    public function isActive() : bool
    {
        return self::STATUS_ACTIVE === $this->value;
    }

    public static function toActive() : self
    {
        return new self(self::STATUS_ACTIVE);
    }

    public function __toString() : string
    {
        return (string)$this->getValue();
    }
}
