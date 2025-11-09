<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Game;
use App\Payload\CreateGamePayload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/games')]
final class GameController extends AbstractController
{
    #[Route('/create', name: 'app_create_game')]
    public function create(
        #[MapRequestPayload] CreateGamePayload $payload,
        EntityManagerInterface $entityManager,
        Security $security
    )
    {
        /** @var User $user */
        $user = $security->getUser();

        $game = new Game();

        $game->setTitle($payload->title);
        $game->addUser($user);

        $entityManager->persist($game);

        $entityManager->flush();

        return $this->json([
            "id" => $game->getId(),
        ]);
    }

    #[Route('/{game}', name: 'app_game')]
    public function index(Game $game, SerializerInterface $serializer)
    {
        return new Response($serializer->serialize($game, "json", ["groups" => "game"]), 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/{game}/join', name:'app_game_join')]
    public function join(Game $game, Security $security, EntityManagerInterface $entityManager)
    {
        /** @var User $user */
        $user = $security->getUser();

        if (!$game->getUsers()->contains($user)) {
            $game->addUser($user);
            $entityManager->flush();
        }

        return new Response('', 204);
    }

    #[Route('/{game}/night', name: 'app_game_night')]
    public function night(Game $game, EntityManagerInterface $entityManager)
    {
        $game->setIsNight(true);
        $entityManager->flush();

        return new Response('', 204);
    }

    #[Route('/{game}/day', name: 'app_game_day')]
    public function day(Game $game, EntityManagerInterface $entityManager)
    {
        $game->setIsNight(false);
        $entityManager->flush();

        return new Response('', 204);
    }
}
