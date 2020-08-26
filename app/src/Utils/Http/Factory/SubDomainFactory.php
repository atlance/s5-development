<?php

declare(strict_types=1);

namespace App\Utils\Http\Factory;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SubDomainFactory
{
    public function create(RequestStack $stack, string $domain) : SubDomain
    {
        if ($stack->getMasterRequest() instanceof Request) {
            $subDomain = str_replace('.' . $domain, '', $stack->getMasterRequest()->getHttpHost());

            if ($domain === $subDomain) {
                return new SubDomain('');
            }

            return new SubDomain(
                str_replace('.' . $domain, '', $stack->getMasterRequest()->getHttpHost())
            );
        }

        throw new \DomainException('master request not specified.');
    }
}
