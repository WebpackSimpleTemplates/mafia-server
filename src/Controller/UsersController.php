<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FilesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UsersController extends AbstractController
{
  #[Route('/api/users/me', name:"app_user_me", methods:['GET'])]
  public function me(Security $security)
  {
    return $this->json($security->getUser());
  }

  #[Route("/api/users/{id}", name:"app_api_user", methods:['GET', 'POST'])]
  public function findUser(
    Request $request,
    User $user,
    FilesRepository $filesRepository,
    UserPasswordHasherInterface $userPasswordHasher,
    UserRepository $userRepository,
    EntityManagerInterface $entityManager,
  )
  {
    $username = $request->get('username');
    $avatar = $filesRepository->getFromRequest($request, 'avatar');
    $password = $request->get('password');

    if ($username && $userRepository->findOneBy(["username" => $username])) {
      return $this->json([ "error" => "username $username already exist" ], 400);
    }

    if ($username && $user->getUsername() !== $username && !$userRepository->findOneBy(["username" => $username])) {
      $user->setUsername($username);
    }

    if ($avatar) {
      $user->setAvatar($avatar);
    }

    if ($password) {
      $oldPass = $request->get('oldPass');

      if ($oldPass && $userPasswordHasher->isPasswordValid($user, $oldPass)) {
        $user->setPassword($userPasswordHasher->hashPassword($user, $password));
      } else {
        return $this->json([ "error" => "old password is incorrect" ], 400);
      }
    }
    
    $entityManager->persist($user);
    $entityManager->flush();

    return $this->json($user);
  }
}