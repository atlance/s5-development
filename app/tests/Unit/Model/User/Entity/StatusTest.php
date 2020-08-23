<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity;

use App\Model\User\Entity\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testGetValue()
    {
        $status = new Status();
        self::assertNull($status->getValue());
        $status->toWait();
        self::assertEquals('wait', $status->getValue());
    }

    public function testIsActive()
    {
        self::assertTrue(Status::toActive()->isActive());
    }

    public function testIsWait()
    {
        $status = new Status();
        $status->toWait();
        self::assertTrue($status->isWait());
    }

    public function testSetValue()
    {
        $status = new Status();
        $status->setValue(Status::STATUS_NEW);
        self::assertInstanceOf(Status::class, $status);
        $this->expectExceptionMessage('not allowed status');
        $status->setValue('STATUS_FOO');
        self::assertEquals('new', $status->setValue(Status::STATUS_NEW));
    }

    public function testToString()
    {
        self::assertEquals('new', (string)new Status(Status::STATUS_NEW));
    }
}
