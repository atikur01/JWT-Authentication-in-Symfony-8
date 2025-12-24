<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // 1️⃣ Validation
        if (
            empty($data['email']) ||
            empty($data['password'])
        ) {
            return $this->json([
                'status' => false,
                'message' => 'Email and password required'
            ], 400);
        }

        // 2️⃣ Check user already exists
        $existingUser = $em->getRepository(User::class)
            ->findOneBy(['email' => $data['email']]);

        if ($existingUser) {
            return $this->json([
                'status' => false,
                'message' => 'User already exists'
            ], 409);
        }

        // 3️⃣ Create User
        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);

        // 4️⃣ Hash Password
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $data['password']
        );

        $user->setPassword($hashedPassword);

        // 5️⃣ Save
        $em->persist($user);
        $em->flush();

        // 6️⃣ Response
        return $this->json([
            'status' => true,
            'message' => 'User registered successfully'
        ], 201);
    }
}
