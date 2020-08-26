<?php

declare(strict_types=1);

namespace App\Controller\Web\SubDomain;

use App\Utils\Http\Factory\SubDomain;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="show", methods={"GET"})
 */
class IndexController extends AbstractController
{
    public function __invoke(Request $request, SubDomain $subDomain) : Response
    {
        return $this->render('web/subdomain/index.html.twig', [
            'subDomain' => (string)$subDomain,
        ]);
    }
}
