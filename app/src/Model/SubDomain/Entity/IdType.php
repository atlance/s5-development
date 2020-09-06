<?php

declare(strict_types=1);

namespace App\Model\SubDomain\Entity;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class IdType extends Type
{
    public const NAME = 'subdomain';

    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ? string
    {
        return $value instanceof Id ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) : ? Id
    {
        return \is_string($value) ? new Id($value) : null;
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
        $fieldDeclaration['length'] = $this->getDefaultLength($platform);

        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function getDefaultLength(AbstractPlatform $platform) : int
    {
        return 16;
    }
}
