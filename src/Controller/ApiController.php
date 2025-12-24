<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiController extends AbstractController
{
    #[Route('/api/user', methods: ['GET'])]
    public function user(): JsonResponse
    {
        return $this->json(['message' => 'User Access']);
    }

    #[Route('/api/admin', methods: ['GET'])]
    public function admin(): JsonResponse
    {
        return $this->json(['message' => 'Admin Access']);
    }

    #[Route('/api/users/{id}', methods: ['DELETE'])]
    public function delete(
        User $user,
        EntityManagerInterface $em
    ): JsonResponse {
        $this->denyAccessUnlessGranted('USER_DELETE', $user);

        $em->remove($user);
        $em->flush();

        return $this->json([
            'message' => 'User deleted'
        ]);
    }


}
