<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity;

use App\Model\User\Entity\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testGetFirst()
    {
        self::assertEquals('Brad', (new Name('Brad', 'Pitt'))->getFirst());
    }

    public function testGetLast()
    {
        self::assertEquals('Pitt', (new Name('Brad', 'Pitt'))->getLast());
    }

    public function testGetFull()
    {
        $name = new Name('Brad', 'Pitt');
        self::assertEquals('Brad Pitt', $name->getFull());
        self::assertNotEquals('brad pitt', $name->getFull());
    }

    public function testConstruct()
    {
        $this->expectExceptionMessage("first name can't be empty");
        new Name('', 'Pitt');
        $this->expectExceptionMessage("last name can't be empty");
        new Name('Brad', '');
    }
}
