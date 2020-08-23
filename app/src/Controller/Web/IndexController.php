<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function __invoke() : Response
    {
        return $this->render('web/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
