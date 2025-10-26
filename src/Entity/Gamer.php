<?php

namespace App\Entity;

use App\Repository\GamerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: GamerRepository::class)]
class Gamer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'gamers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?Game $game = null;

    #[ORM\ManyToOne(fetch:"EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usr = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getUsr(): ?User
    {
        return $this->usr;
    }

    public function setUsr(?User $usr): static
    {
        $this->usr = $usr;

        return $this;
    }
}
