<?php

declare(strict_types=1);

namespace App\Model\Company\Entity;

use App\Doctrine\Dbal\Type\Uuid;
use App\Model\SubDomain\Entity\SubDomain;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="companies", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"sub_domain"})
 * })
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="uuid")
     */
    private Uuid $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\SubDomain\Entity\SubDomain")
     * @ORM\JoinColumn(name="sub_domain", referencedColumnName="id")
     */
    private ? SubDomain $subDomain;

    /**
     * @ORM\Column(name="created_at", type="date_immutable")
     */
    private DateTimeImmutable $createdAt;

    public function __construct(Uuid $id, DateTimeImmutable $date)
    {
        $this->id = $id;
        $this->createdAt = $date;
    }

    public function getId() : Uuid
    {
        return $this->id;
    }

    public function getSubDomain() : ?SubDomain
    {
        return $this->subDomain;
    }

    public function setSubDomain(?SubDomain $subDomain) : self
    {
        $this->subDomain = $subDomain;

        return $this;
    }
}
