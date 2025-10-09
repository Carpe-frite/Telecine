<?php

namespace App\Entity;

use App\Repository\TakePartInRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TakePartInRepository::class)]
class TakePartIn
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "participations")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "user_id", nullable: false, onDelete: "CASCADE")]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: "participants")]
    #[ORM\JoinColumn(name: "event_id", referencedColumnName: "event_id", nullable: false, onDelete: "CASCADE")]
    private ?Event $event = null;


    #[ORM\Column]
    private ?bool $user_has_confirmed = null;

     public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;
        return $this;
    }

    public function isUserHasConfirmed(): ?bool
    {
        return $this->user_has_confirmed;
    }

    public function setUserHasConfirmed(bool $user_has_confirmed): static
    {
        $this->user_has_confirmed = $user_has_confirmed;

        return $this;
    }
}
