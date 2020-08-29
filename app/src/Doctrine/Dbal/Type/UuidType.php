<?php

declare(strict_types=1);

namespace App\Doctrine\Dbal\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UuidType extends Type
{
    public const NAME = 'uuid';

    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ? string
    {
        return $value instanceof Uuid ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) : ? Uuid
    {
        return \is_string($value) ? new Uuid($value) : null;
    }

    public function getName() : string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) : string
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function getDefaultLength(AbstractPlatform $platform) : int
    {
        return 36;
    }
}
