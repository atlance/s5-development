<?php

declare(strict_types=1);

namespace App\Doctrine\Orm\Fixtures;

use App\Doctrine\Dbal\Type\Uuid;
use App\Model\Company\Entity\Company;
use App\Model\SubDomain\Entity\SubDomain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_USER_COMPANY_REFERENCE = 'admin-user-company';

    public function load(ObjectManager $manager) : void
    {
        /** @var SubDomain $subDomain */
        $subDomain = $this->getReference(SubDomainFixtures::ADMIN_USER_SUBDOMAIN_REFERENCE);
        $company = new Company(Uuid::generate(), new \DateTimeImmutable());
        $company->setSubDomain($subDomain);

        $manager->persist($company);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_COMPANY_REFERENCE, $company);
    }

    public function getDependencies() : array
    {
        return [
            SubDomainFixtures::class,
        ];
    }
}
