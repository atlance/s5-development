<?php

declare(strict_types=1);

namespace App\Controller\Web\User\UseCase\Auth\Email;

use App\Model\User\UseCase\Auth\SignUp;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/signup", name="signup", methods={"GET", "POST"})
 */
class SignUpRequestController extends AbstractController
{
    public function __invoke(Request $request, SignUp\Email\Request\Handler $handler) : Response
    {
        $command = new SignUp\Email\Request\Command();

        $signUpForm = $this->createForm(SignUp\Email\Request\Form::class, $command);
        $signUpForm->handleRequest($request);

        if ($signUpForm->isSubmitted() && $signUpForm->isValid()) {
            try {
                $handler->handle($signUpForm->getData());
                $this->addFlash('success', 'Check your email.');

                return $this->redirectToRoute('web.index');
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('web/auth/email/signup.html.twig', [
            'signUpForm' => $signUpForm->createView(),
        ]);
    }
}
