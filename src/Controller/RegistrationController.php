<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FilesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_register')]
    public function register(
        Request $request,
        FilesRepository $filesRepository,
        UserRepository $userRepository,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = new User();
        $username = $request->get('username');

        if ($userRepository->findOneBy(["username" => $username])) {
            return $this->json([ "error" => "username $username already exist" ], 400);
        }

        $user->setUsername($username);
        $user->setAvatar($filesRepository->getFromRequest($request, 'avatar'));
        $user->setPassword($userPasswordHasher->hashPassword($user, $request->get('password')));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([ "result" => "ok" ]);
    }
}
