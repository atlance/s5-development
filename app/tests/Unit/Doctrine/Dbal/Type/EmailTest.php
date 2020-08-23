<?php

declare(strict_types=1);

namespace App\Tests\Doctrine\Dbal\Type;

use App\Doctrine\Dbal\Type\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testConstruct()
    {
        $this->expectExceptionMessage("email can't be empty");
        new Email('');
        $this->expectExceptionMessage('incorrect email.');
        new Email('abc@ab');
    }

    public function testGetValue()
    {
        $email = new Email('a@a.a');
        self::assertEquals('a@a.a', $email->getValue());
    }

    public function testToString()
    {
        $email = new Email('a@a.a');
        self::assertEquals('a@a.a', (string)$email);
    }

    public function testIsEqual()
    {
        $email1 = new Email('a@a.a');
        $email2 = new Email('a@a.a');
        self::assertTrue($email1->isEqual($email2));
    }
}
