<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\Token;
use DateInterval;
use Ramsey\Uuid\Uuid;

class ResetPasswordTokenizer
{
    private DateInterval $interval;

    public function __construct(DateInterval $interval)
    {
        $this->interval = $interval;
    }

    public function generate() : Token
    {
        return new Token(Uuid::uuid4()->toString(), (new \DateTimeImmutable())->add($this->interval));
    }
}
