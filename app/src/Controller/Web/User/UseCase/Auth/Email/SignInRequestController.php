<?php

declare(strict_types=1);

namespace App\Controller\Web\User\UseCase\Auth\Email;

use App\Model\User\UseCase\Auth\SignIn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/signin", name="signin", methods={"GET", "POST"})
 */
class SignInRequestController extends AbstractController
{
    public function __invoke(AuthenticationUtils $authenticationUtils) : Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error instanceof AuthenticationException) {
            $this->addFlash('error', $error);
        }

        return $this->render('web/auth/email/signin.html.twig', [
            'signInForm' => $this->createForm(SignIn\Email\Request\Form::class)->createView(),
        ]);
    }
}
