<?php

declare(strict_types=1);

namespace App\Controller\Web\User\UseCase\Profile;

use App\Annotation\Uuid;
use App\Model\User\Entity\Id;
use App\ReadModel\User\UserFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{token}/show", name="show", methods={"GET"}, requirements={"token"=Uuid::EXP_PATTERN})
 */
class ShowController extends AbstractController
{
    private UserFetcher $fetcher;

    public function __construct(UserFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    public function __invoke(string $token) : Response
    {
        $user = $this->fetcher->get(new Id($token));

        return $this->render('web/user/profile/show.html.twig', compact('user'));
    }
}
