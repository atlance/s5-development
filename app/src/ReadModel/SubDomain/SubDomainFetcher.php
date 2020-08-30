<?php

declare(strict_types=1);

namespace App\ReadModel\SubDomain;

use App\Model\SubDomain\Entity\Id;
use App\ReadModel\Fetcher;
use App\ReadModel\SubDomain\View\SubDomainFromRequestView;
use Doctrine\DBAL\FetchMode;

class SubDomainFetcher extends Fetcher
{
    public function getSubDomainFromRequest(Id $id) : SubDomainFromRequestView
    {
        $qb = $this->getQueryBuilder()
            ->select(['s.id'])
            ->from('subdomains', 's')
            ->where('s.id = :id')
            ->setParameter(':id', $id);

        $subDomain = $this->getResultStatement($qb, FetchMode::CUSTOM_OBJECT, SubDomainFromRequestView::class)->fetch();

        if ($subDomain instanceof SubDomainFromRequestView) {
            return $subDomain;
        }

        throw new \DomainException('subdomain not found.');
    }
}
