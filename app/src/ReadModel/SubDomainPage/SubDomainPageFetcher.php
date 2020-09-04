<?php

declare(strict_types=1);

namespace App\ReadModel\SubDomainPage;

use App\Model\SubDomain\Entity\Id;
use App\ReadModel\Fetcher;
use App\ReadModel\SubDomainPage\View\SubDomainPageView;
use Doctrine\DBAL\FetchMode;

class SubDomainPageFetcher extends Fetcher
{
    public function getSubDomainPage(Id $id, string $slug) : SubDomainPageView
    {
        $qb = $this->getQueryBuilder()
            ->select(['sp.template'])
            ->from('subdomains_pages', 'sp')
            ->where('sp.sub_domain = :subDomain')
            ->andWhere('sp.path = :path')
            ->setParameter(':subDomain', $id)
            ->setParameter(':path', $slug);

        $subDomain = $this->getResultStatement($qb, FetchMode::CUSTOM_OBJECT, SubDomainPageView::class)->fetch();

        if ($subDomain instanceof SubDomainPageView) {
            return $subDomain;
        }

        throw new \DomainException('subdomain page not found.');
    }
}
