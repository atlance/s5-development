<?php

declare(strict_types=1);

namespace App\Model\SubDomain\Entity;

use App\Doctrine\Dbal\Type\Uuid;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="subdomains_pages")
 */
class Page
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="uuid")
     */
    private Uuid $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\SubDomain\Entity\SubDomain")
     * @ORM\JoinColumn(name="sub_domain", referencedColumnName="id", nullable=false)
     */
    private SubDomain $subDomain;

    /**
     * @ORM\Column(name="path", type="string", nullable=false)
     */
    private string $path;

    /**
     * @ORM\Column(name="template", type="text", nullable=false)
     */
    private string $template;

    /**
     * @ORM\Column(name="created_at", type="date_immutable", nullable=false)
     */
    private DateTimeImmutable $createdAt;

    public function __construct(
        Uuid $id,
        SubDomain $subDomain,
        DateTimeImmutable $createdAt,
        string $path,
        string $template
    ) {
        $this->id = $id;
        $this->subDomain = $subDomain;
        $this->createdAt = $createdAt;
        $this->path = $path;
        $this->template = $template;
    }

    public function getId() : Uuid
    {
        return $this->id;
    }

    public function getCreatedAt() : DateTimeImmutable
    {
        return $this->createdAt;
    }
}
