<?php

declare(strict_types=1);

namespace App\Controller\Web\User\UseCase\Profile;

use App\Annotation\Uuid;
use App\Model\User\Entity\User;
use App\Model\User\UseCase\Profile\Edit;
use App\Security\Voter\User\UseCase\Profile\EditAccess;
use DomainException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{token}/edit", name="edit", methods={"GET", "POST"}, requirements={"token"=Uuid::EXP_PATTERN})
 * @ParamConverter("user", options={"id" = "token"})
 * @IsGranted(EditAccess::EDIT, subject="token")
 */
class EditController extends AbstractController
{
    public function __invoke(User $user, Request $request, string $token, Edit\Handler $handler) : Response
    {
        $command = Edit\Command::fromUser($user);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($form->getData());

                return $this->redirectToRoute('web.auth.email.signin');
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('web/user/profile/edit.html.twig', ['form' => $form->createView()]);
    }
}
