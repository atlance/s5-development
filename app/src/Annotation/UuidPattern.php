<?php

declare(strict_types=1);

namespace App\Annotation;

class UuidPattern
{
    /**
     * Regular expression pattern for matching a UUID of any variant.
     */
    public const VALUE = '[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}';
}
