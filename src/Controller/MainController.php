<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Game;
use App\Payload\CreateGamePayload;
use App\Repository\GameRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/main')]
class MainController extends AbstractController
{
    #[Route('/create-game', name: 'app_create_game')]
    public function create(
        #[MapRequestPayload()] CreateGamePayload $payload,
        EntityManagerInterface $entityManager,
        Security $security
    )
    {
        $game = new Game();

        $game->setTitle($payload->title);
        $game->setMaxGamers($payload->maxGamers);
        if ($payload->start) {
            $game->setStart(DateTime::createFromFormat("Y-m-d H:i:s", (str_replace("T", " ", $payload->start)).":00"));
        }

        /** @var User $user */
        $user = $security->getUser();

        $game->addUser($user);
        $game->setMaster($user);

        $entityManager->persist($game);

        $entityManager->flush();

        return $this->json([
            "id" => $game->getId(),
        ]);
    }

    #[Route('/games', name: 'app_get_open_games')]
    public function index(Request $request, GameRepository $gameRepository)
    {

        $games = $gameRepository->search($request->query->get("search", null));

        return $this->json($games, context:["group" => "searching"]);
    }
}
