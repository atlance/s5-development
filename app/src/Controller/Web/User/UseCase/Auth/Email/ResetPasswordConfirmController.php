<?php

declare(strict_types=1);

namespace App\Controller\Web\User\UseCase\Auth\Email;

use App\Annotation\UuidPattern;
use App\Model\User\UseCase\Auth\Reset\Password;
use App\ReadModel\User\Auth\AuthView;
use App\ReadModel\User\UserFetcher;
use App\Security\Auth\Email\Authenticator;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * @Route("/reset-password/confirm/{token}", name="reset.password.confirm", requirements={"token"=UuidPattern::VALUE})
 */
class ResetPasswordConfirmController extends AbstractController
{
    private UserFetcher $userFetcher;

    public function __construct(UserFetcher $userFetcher)
    {
        $this->userFetcher = $userFetcher;
    }

    public function __invoke(
        Request $request,
        string $token,
        Password\Confirm\Handler $handler,
        UserProviderInterface $userProvider,
        GuardAuthenticatorHandler $guardHandler,
        Authenticator $authenticator
    ) : Response {
        $user = $this->userFetcher->findByResetToken($token);
        if (!$user instanceof AuthView) {
            $this->addFlash('error', 'Incorrect or already confirmed reset token.');

            return $this->redirectToRoute('web.auth.email.reset.password');
        }

        $command = new Password\Confirm\Command($token);
        $form = $this->createForm(Password\Confirm\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                $response = $guardHandler->authenticateUserAndHandleSuccess(
                    $userProvider->loadUserByUsername($user->email),
                    $request,
                    $authenticator,
                    'web_email'
                );

                if ($response instanceof Response) {
                    return $response;
                }
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('web/auth/email/reset_password/form.html.twig', [
            'resetPasswordForm' => $form->createView(),
        ]);
    }
}
