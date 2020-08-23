<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Token
{
    /**
     * @ORM\Column(name="token", type="string", nullable=true)
     */
    private ? string $token;

    /**
     * @ORM\Column(name="expired_at", type="datetime_immutable", nullable=true)
     */
    private ? DateTimeImmutable $expiredAt;

    public function __construct(string $token = null, \DateTimeImmutable $expiredAt = null)
    {
        $this->token = $token;
        $this->expiredAt = $expiredAt;
    }

    public function getToken() : ?string
    {
        return $this->token;
    }

    public function getExpiredAt() : ?\DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function isExpiredTo(\DateTimeImmutable $date) : bool
    {
        return $this->expiredAt <= $date;
    }

    public function __toString()
    {
        return (string)$this->token;
    }
}
