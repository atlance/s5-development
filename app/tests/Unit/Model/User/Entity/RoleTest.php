<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity;

use App\Model\User\Entity\Role;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function testToString()
    {
        self::assertEquals('ROLE_ADMIN', (string)Role::admin());
    }

    public function testIsAdmin()
    {
        $role = Role::admin();
        self::assertFalse($role->isUser());
        self::assertTrue($role->isAdmin());
    }

    public function testUser()
    {
        $role = Role::user();
        self::assertTrue($role->isUser());
    }

    public function testConstruct()
    {
        $role = new Role(Role::ADMIN);
        self::assertInstanceOf(Role::class, $role);
    }

    public function testIsEqual()
    {
        $role = new Role(Role::ADMIN);
        self::assertTrue($role->isEqual(Role::admin()));
    }

    public function testGetName()
    {
        $role = new Role(Role::ADMIN);
        self::assertEquals('ROLE_ADMIN', $role->getName());
    }
}
