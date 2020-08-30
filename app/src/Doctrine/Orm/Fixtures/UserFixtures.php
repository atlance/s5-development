<?php

declare(strict_types=1);

namespace App\Doctrine\Orm\Fixtures;

use App\Doctrine\Dbal\Type\Email;
use App\Doctrine\Dbal\Type\Uuid;
use App\Model\Company\Entity\Company;
use App\Model\User\Entity\Name;
use App\Model\User\Entity\User;
use App\Model\User\Service\PasswordHasher;
use App\Model\User\Service\SignUpConfirmTokenizer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private PasswordHasher $hasher;
    private SignUpConfirmTokenizer $tokenizer;

    public function __construct(PasswordHasher $hasher, SignUpConfirmTokenizer $tokenizer)
    {
        $this->hasher = $hasher;
        $this->tokenizer = $tokenizer;
    }

    public function load(ObjectManager $manager) : void
    {
        $uuid = Uuid::generate();
        $name = new Name('Fabien', 'Potencier');
        $email = new Email('fabien@potencier.org');
        $token = $this->tokenizer->generate();
        $password = 'admin';
        $hash = $this->hasher->hash($password);

        $user = User::signUpByEmail($uuid, $name, $email, new \DateTimeImmutable(), $token, $hash);
        $user->confirmSignUp();
        $user->toAdmin();

        /** @var Company $company */
        $company = $this->getReference(CompanyFixtures::ADMIN_USER_COMPANY_REFERENCE);
        $user->setCompany($company);

        $manager->persist($user);
        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
