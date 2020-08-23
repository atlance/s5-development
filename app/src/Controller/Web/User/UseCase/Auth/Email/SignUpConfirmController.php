<?php

declare(strict_types=1);

namespace App\Controller\Web\User\UseCase\Auth\Email;

use App\Annotation\Uuid;
use App\Model\User\UseCase\Auth\SignUp;
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
 * @Route("/confirm/{token}", name="signup.confirm", requirements={"token"=Uuid::EXP_PATTERN})
 */
class SignUpConfirmController extends AbstractController
{
    private UserFetcher $userFetcher;

    public function __construct(UserFetcher $userFetcher)
    {
        $this->userFetcher = $userFetcher;
    }

    public function __invoke(
        Request $request,
        string $token,
        SignUp\Email\Confirm\Handler $handler,
        UserProviderInterface $userProvider,
        GuardAuthenticatorHandler $guardHandler,
        Authenticator $authenticator
    ) : Response {
        $user = $this->userFetcher->findByConfirmToken($token);
        if (!$user instanceof AuthView) {
            $this->addFlash('error', 'Incorrect or already confirmed token.');

            return $this->redirectToRoute('web.auth.email.signup');
        }

        $command = new SignUp\Email\Confirm\Command($token);

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

        return $this->redirectToRoute('web.auth.email.signup');
    }
}
