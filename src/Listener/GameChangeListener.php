<?php

namespace App\Listener;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsEntityListener(event:Events::preFlush, method:'preFlush', entity:Game::class)]
class GameChangeListener
{
  public function __construct(
    private ParameterBagInterface $parameter,
    private HttpClientInterface $client,
    private LoggerInterface $logger,
    private SerializerInterface $serializer
  )
  {}

  public function preFlush(Game $game)
  {
    if ($this->parameter->get("app.push_server") === "none") {
      return;
    }

    $body = $this->serializer->serialize($game, "json", ['groups' => "game"]);

    try {
      $response = $this->client->request(
          "POST",
          $this->parameter->get("app.push_server")."/game/".$game->getId(),
          [
              'headers' => [ 'Content-Type' => 'application/json', ],
              'body' => $body,
          ]
      );

      if ($response->getStatusCode() !== 204) {
          $this->logger->error("sending push status non 204", [
              "body" => $body,
              "status" => $response->getStatusCode(),
          ]);
      }

      $this->logger->debug("push sended", ["body" => $body]);
    } catch (\Throwable $th) {
        $this->logger->error("error sending push", (array) $th);
    }

  }
}