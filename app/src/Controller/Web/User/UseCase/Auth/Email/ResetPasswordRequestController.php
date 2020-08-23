<?php

declare(strict_types=1);

namespace App\Controller\Web\User\UseCase\Auth\Email;

use App\Model\User\UseCase\Auth\Reset\Password;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reset-password/request", name="reset.password", methods={"GET", "POST"})
 */
class ResetPasswordRequestController extends AbstractController
{
    public function __invoke(Request $request, Password\Request\Handler $handler) : Response
    {
        $command = new Password\Request\Command();

        $resetPasswordForm = $this->createForm(Password\Request\Form::class, $command);
        $resetPasswordForm->handleRequest($request);

        if ($resetPasswordForm->isSubmitted() && $resetPasswordForm->isValid()) {
            try {
                $handler->handle($resetPasswordForm->getData());
                $this->addFlash('success', 'Check your email.');

                return $this->redirectToRoute('web.index');
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render(
            'web/auth/email/reset_password/token.form.html.twig', [
            'email' => $command->email,
            'resetPasswordTokenForm' => $this->createForm(Password\Request\Form::class)->createView(),
        ]);
    }
}
