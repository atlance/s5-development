<?php

declare(strict_types=1);

namespace App\Model\SubDomain\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="subdomains")
 */
class SubDomain
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="subdomain")
     */
    private Id $id;

    /**
     * @ORM\Column(name="created_at", type="date_immutable")
     */
    private DateTimeImmutable $createdAt;

    public function __construct(Id $id, DateTimeImmutable $date)
    {
        $this->id = $id;
        $this->createdAt = $date;
    }

    public function getId() : Id
    {
        return $this->id;
    }

    public function getCreatedAt() : DateTimeImmutable
    {
        return $this->createdAt;
    }
}
