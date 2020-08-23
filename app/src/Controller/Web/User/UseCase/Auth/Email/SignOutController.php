<?php

declare(strict_types=1);

namespace App\Controller\Web\User\UseCase\Auth\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/signout", name="signout", methods={"GET"})
 */
class SignOutController extends AbstractController
{
    public function __invoke() : Response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
