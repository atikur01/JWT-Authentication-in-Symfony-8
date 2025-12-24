<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
class UserVoter extends Voter
{
    public const DELETE = 'USER_DELETE';

    public function __construct(private Security $security) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::DELETE && $subject instanceof User;
    }

    protected function voteOnAttribute(
        string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool {
        $currentUser = $token->getUser();

        if (!$currentUser instanceof User) {
            return false;
        }

        // ✅ Admin can delete anyone
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // ✅ User can delete ONLY himself
        return $currentUser->getId() === $subject->getId();
    }
}
