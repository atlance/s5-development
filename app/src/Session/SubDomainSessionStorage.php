<?php

declare(strict_types=1);

namespace App\Session;

use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class SubDomainSessionStorage extends NativeSessionStorage
{
    public function setOptions(array $options = []) : void
    {
        $options['cookie_domain'] = getenv('SITE_DOMAIN');

        parent::setOptions($options);
    }
}
