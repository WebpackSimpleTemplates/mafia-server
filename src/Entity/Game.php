<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
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
    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $users;

    #[ORM\ManyToOne]
    private ?User $master = null;

    #[ORM\Column(options:['default' => true])]
    #[Groups("game")]
    private ?bool $isRecruitmenting = null;

    #[ORM\Column(options:['default' => false])]
    #[Groups("game")]
    private ?bool $isNight = null;

    #[ORM\ManyToOne]
    private ?User $speaker = null;

    #[ORM\ManyToOne]
    private ?User $accent = null;

    #[ORM\Column(options:['default' => true])]
    #[Groups("game")]
    private ?bool $isFreeSpeech = null;

    /**
     * @var Collection<int, User>
     */
    #[JoinTable("dead_users")]
    #[ORM\ManyToMany(targetEntity: User::class)]
    #[Groups("game")]
    private Collection $dead;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->dead = new ArrayCollection();
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

    public function getMaster(): ?User
    {
        return $this->master;
    }

    public function setMaster(?User $master): static
    {
        $this->master = $master;

        return $this;
    }

    #[Groups("game")]
    public function getMasterId(): ?int
    {
        return $this->master ? $this->master->getId() : null;
    }

    #[Groups("game")]
    public function getSpeakerId(): ?int
    {
        return $this->speaker ? $this->speaker->getId() : null;
    }

    public function isRecruitmenting(): ?bool
    {
        return $this->isRecruitmenting;
    }

    public function setIsRecruitmenting(bool $isRecruitmenting): static
    {
        $this->isRecruitmenting = $isRecruitmenting;

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

    public function getSpeaker(): ?User
    {
        return $this->speaker;
    }

    public function setSpeaker(?User $speaker): static
    {
        $this->speaker = $speaker;

        return $this;
    }

    public function getAccent(): ?User
    {
        return $this->accent;
    }

    public function setAccent(?User $accent): static
    {
        $this->accent = $accent;

        return $this;
    }

    public function isFreeSpeech(): ?bool
    {
        return $this->isFreeSpeech;
    }

    public function setIsFreeSpeech(bool $isFreeSpeech): static
    {
        $this->isFreeSpeech = $isFreeSpeech;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getDead(): Collection
    {
        return $this->dead;
    }

    public function addDead(User $dead): static
    {
        if (!$this->dead->contains($dead)) {
            $this->dead->add($dead);
        }

        return $this;
    }

    public function removeDead(User $dead): static
    {
        $this->dead->removeElement($dead);

        return $this;
    }

    public function speaker(User $user)
    {
        $this->setSpeaker($user);
        $this->setAccent($user);
        $this->setIsFreeSpeech(false);
    }

    public function presenter(User $user)
    {
        if ($this->speaker->getId() !== $user->getId()) {
            $this->setSpeaker(null);
        }
        $this->setAccent($user);
        $this->setIsFreeSpeech(false);
    }

    public function silence()
    {
        $this->setSpeaker(null);
        $this->setAccent(null);
        $this->setIsFreeSpeech(false);
    }

    public function freeSpeech()
    {
        $this->setSpeaker(null);
        $this->setAccent(null);
        $this->setIsFreeSpeech(true);
    }

    public function dump()
    {
        $state = [];

        $state['id'] = $this->id;
        $state['gamers'] = $this->users;
        $state['masterId'] = $this->master?->getId();
        $state['isFreeSpeech'] = $this->isFreeSpeech;
        $state['speakerId'] = $this->speaker?->getId();
        $state['accentId'] = $this->accent?->getId();
        $state['isRecruipmenting'] = $this->isRecruitmenting;
        $state['isNight'] = $this->isNight;

        return $state;
    }
}
