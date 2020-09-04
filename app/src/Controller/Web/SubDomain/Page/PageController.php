<?php

declare(strict_types=1);

namespace App\Controller\Web\SubDomain\Page;

use App\Model\SubDomain\Entity\Id;
use App\ReadModel\SubDomain\View\SubDomainFromRequestView;
use App\ReadModel\SubDomainPage\SubDomainPageFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/page/{slug}", name="show.page", methods={"GET"})
 */
class PageController extends AbstractController
{
    public function __invoke(Request $request, SubDomainFromRequestView $subDomain, SubDomainPageFetcher $fetcher) : Response
    {
        try {
            $template = $fetcher->getSubDomainPage(new Id((string)$subDomain), $request->getRequestUri());
        } catch (\DomainException $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }

        return $this->render('web/subdomain/page/index.html.twig', ['template' => $template]);
    }
}
