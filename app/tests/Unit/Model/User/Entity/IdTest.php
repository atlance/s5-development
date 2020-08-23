<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity;

use App\Model\User\Entity\Id;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class IdTest extends TestCase
{
    public function testGetValue()
    {
        $id = new Id((string)Id::generate());
        self::assertNotEmpty($id->getValue());
        self::assertIsString($id->getValue());
    }

    public function testGenerate()
    {
        $id = new Id((string)Id::generate());
        self::assertNotEquals($id->getValue(), Id::generate());
        self::assertTrue(Uuid::isValid($id->getValue()));
    }

    public function testConstruct()
    {
        $this->expectExceptionMessage('Not valid UUID');
        new Id('foo');
        $id = new Id((string)Id::generate());
        self::assertInstanceOf(Id::class, $id);
    }

    public function testToString()
    {
        $id = new Id((string)Id::generate());
        self::assertEquals($id->getValue(), (string)$id);
    }
}
