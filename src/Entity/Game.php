<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("game")]
    private ?int $id = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, cascade:['persist'])]
    private Collection $users;

    #[ORM\Column(options:['default' => false])]
    #[Groups("game")]
    private ?bool $isNight = false;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("game")]
    private ?string $winner = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("game")]
    private ?string $title = null;

    #[ORM\Column(options:['default' => true])]
    private ?bool $isRecruitment = true;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups("game")]
    public function getGamers(): Collection
    {
        return $this->users;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function isNight(): ?bool
    {
        return $this->isNight;
    }

    public function setIsNight(bool $isNight): static
    {
        $this->isNight = $isNight;

        return $this;
    }


    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(?string $winner): static
    {
        $this->winner = $winner;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isRecruitment(): ?bool
    {
        return $this->isRecruitment;
    }

    public function setIsRecruitment(bool $isRecruitment): static
    {
        $this->isRecruitment = $isRecruitment;

        return $this;
    }
}
