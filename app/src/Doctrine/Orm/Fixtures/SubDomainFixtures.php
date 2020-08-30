<?php

declare(strict_types=1);

namespace App\Doctrine\Orm\Fixtures;

use App\Model\SubDomain\Entity\Id;
use App\Model\SubDomain\Entity\SubDomain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubDomainFixtures extends Fixture
{
    public const ADMIN_USER_SUBDOMAIN_REFERENCE = 'admin-user-subdomain';

    public function load(ObjectManager $manager) : void
    {
        $subDomain = new SubDomain(new Id('fabien'), new \DateTimeImmutable());

        $manager->persist($subDomain);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_SUBDOMAIN_REFERENCE, $subDomain);
    }
}
