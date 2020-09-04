<?php

declare(strict_types=1);

namespace App\Doctrine\Orm\Fixtures;

use App\Doctrine\Dbal\Type\Uuid;
use App\Model\SubDomain\Entity\Id;
use App\Model\SubDomain\Entity\Page;
use App\Model\SubDomain\Entity\SubDomain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubDomainPageFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_USER_SUBDOMAIN_REFERENCE = 'admin-user-subdomain';

    public function load(ObjectManager $manager) : void
    {
        /** @var SubDomain $subDomain */
        $subDomain = $this->getReference(SubDomainFixtures::ADMIN_USER_SUBDOMAIN_REFERENCE);
        $page = new Page(
            Uuid::generate(),
            $subDomain,
            new \DateTimeImmutable(),
            '/page/admin',
            'Hi{% if app.user is not null %} {{ app.user.username }}!{% else %}.{% endif %}'
        );

        $manager->persist($page);
        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            SubDomainFixtures::class,
        ];
    }
}
