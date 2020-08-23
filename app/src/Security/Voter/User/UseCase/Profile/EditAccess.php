<?php

declare(strict_types=1);

namespace App\Security\Voter\User\UseCase\Profile;

use App\Model\User\Entity\Status;
use App\Security\Auth\UserIdentity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EditAccess extends Voter
{
    public const EDIT = 'user_profile_edit';

    private AuthorizationCheckerInterface $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject) : bool
    {
        return self::EDIT === $attribute;
    }

    /**
     * @param string $attribute
     * @param mixed  $subject   - В данном случае это uuid пользователя как строка
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) : bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserIdentity) {
            return false;
        }

        return $this->security->isGranted('ROLE_ADMIN')
            || ($subject === $user->getId() && Status::STATUS_ACTIVE === $user->getStatus());
    }
}
