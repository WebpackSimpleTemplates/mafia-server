<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Gamer>
     */
    #[ORM\OneToMany(targetEntity: Gamer::class, mappedBy: 'game', orphanRemoval: true, fetch:'EAGER', cascade:['persist'])]
    private Collection $gamers;

    public function __construct()
    {
        $this->gamers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Gamer>
     */
    public function getGamers(): Collection
    {
        return $this->gamers;
    }

    public function addGamer(Gamer $gamer): static
    {
        if (!$this->gamers->contains($gamer)) {
            $this->gamers->add($gamer);
            $gamer->setGame($this);
        }

        return $this;
    }

    public function removeGamer(Gamer $gamer): static
    {
        if ($this->gamers->removeElement($gamer)) {
            // set the owning side to null (unless already changed)
            if ($gamer->getGame() === $this) {
                $gamer->setGame(null);
            }
        }

        return $this;
    }

    public function hasUser(User $user)
    {
        foreach ($this->gamers as $gamer) {
            if ($gamer->getUsr()->getId() == $user->getId()) {
                return true;
            }
        }

        return false;
    }

    public function joinUser(User $user)
    {
        $gamer = new Gamer();
        $gamer->setUsr($user);
        $gamer->setGame($this);

        $this->gamers->add($gamer);
    }

    public function getUsers()
    {
        $users = [];

        foreach ($this->gamers as $gamer) {
            $users[] = $gamer->getUsr();
        }

        return $users;
    }
}
