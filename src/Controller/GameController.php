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
        $state['masterId'] = $game->getMasterId();
        $state['isFreeSpeech'] = $game->isFreeSpeech();
        $state['speakerId'] = $game->getSpeaker()?->getId();
        $state['accentId'] = $game->getAccent()?->getId();
        $state['isRecruipmenting'] = $game->isRecruitmenting();
        $state['isNight'] = $game->isNight();

        return $this->json($state);
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

    #[Route('/{game}/start', name: 'app_game_start')]
    public function start(Game $game, EntityManagerInterface $entityManager)
    {
        $game->setIsRecruitmenting(false);
        $entityManager->flush();

        return new Response('', 204);
    }

    #[Route('/{game}/night', name: 'app_game_night')]
    public function night(Game $game, EntityManagerInterface $entityManager)
    {
        $game->setIsNight(true);
        $game->silence();
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

    #[Route('/{game}/accent/{user}', name: 'app_game_set_accent')]
    public function setAccent(Game $game, User $user, EntityManagerInterface $entityManager)
    {
        $game->presenter($user);
        $entityManager->flush();

        return new Response('', 204);
    }

    #[Route('/{game}/speaker/{user}', name: 'app_game_set_speaker')]
    public function setSpeaker(Game $game, User $user, EntityManagerInterface $entityManager)
    {
        $game->speaker($user);
        $entityManager->flush();

        return new Response('', 204);
    }

    #[Route('/{game}/free-speech', name: 'app_game_enable_free_speech')]
    public function enableFreeSpeech(Game $game, EntityManagerInterface $entityManager)
    {
        $game->freeSpeech();
        $entityManager->flush();

        return new Response('', 204);
    }

    #[Route('/{game}/silence', name: 'app_game_disable_free_speech')]
    public function disableFreeSpeech(Game $game, EntityManagerInterface $entityManager)
    {
        $game->silence();
        $entityManager->flush();

        return new Response('', 204);
    }
}
