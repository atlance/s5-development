<?php

declare(strict_types=1);

namespace App\Utils\Http\Factory;

use App\Model\SubDomain\Entity\Id;
use App\ReadModel\SubDomain\SubDomainFetcher;
use App\ReadModel\SubDomain\View\SubDomainFromRequestView;
use Symfony\Component\HttpFoundation\Request;

class SubDomainFactory
{
    private SubDomainFetcher $fetcher;
    private string $domain;

    public function __construct(SubDomainFetcher $fetcher, string $domain)
    {
        $this->fetcher = $fetcher;
        $this->domain = $domain;
    }

    public function createFromRequest(Request $request) : SubDomainFromRequestView
    {
        $subDomain = str_replace('.' . $this->domain, '', $request->getHttpHost());
        if ($subDomain === $this->domain) {
            throw new \DomainException("subdomain can't be empty.");
        }

        return $this->fetcher->getSubDomainFromRequest(new Id($subDomain));
    }
}
