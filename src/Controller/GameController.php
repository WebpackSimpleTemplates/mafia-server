<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/games')]
final class GameController extends AbstractController
{
    #[Route('/{game}', name: 'app_game')]
    public function index(Game $game)
    {
        $state = [];

        $state['id'] = $game->getId();
        $state['gamers'] = $game->getUsers();

        return $this->json($state);
    }

    #[Route('/{game}/join', name:'join_to_game')]
    public function join(Game $game, Security $security, EntityManagerInterface $entityManager)
    {
        /** @var User $user */
        $user = $security->getUser();

        if (!$game->hasUser($user)) {
            $game->joinUser($user);
            $entityManager->flush();
        }

        return new Response('', 204);
    }

}
