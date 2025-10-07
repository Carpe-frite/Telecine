<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $event_id = null;

    #[ORM\Column(length: 150)]
    private ?string $event_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $event_date = null;

    #[ORM\Column(length: 150)]
    private ?string $event_movie = null;

    #[ORM\Column]
    private ?\DateTime $event_start = null;

    #[ORM\Column]
    private ?\DateTime $event_end = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): ?int
    {
        return $this->event_id;
    }

    public function setEventId(int $event_id): static
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function setEventName(string $event_name): static
    {
        $this->event_name = $event_name;

        return $this;
    }

    public function getEventDate(): ?\DateTime
    {
        return $this->event_date;
    }

    public function setEventDate(\DateTime $event_date): static
    {
        $this->event_date = $event_date;

        return $this;
    }

    public function getEventMovie(): ?string
    {
        return $this->event_movie;
    }

    public function setEventMovie(string $event_movie): static
    {
        $this->event_movie = $event_movie;

        return $this;
    }

    public function getEventStart(): ?\DateTime
    {
        return $this->event_start;
    }

    public function setEventStart(\DateTime $event_start): static
    {
        $this->event_start = $event_start;

        return $this;
    }

    public function getEventEnd(): ?\DateTime
    {
        return $this->event_end;
    }

    public function setEventEnd(\DateTime $event_end): static
    {
        $this->event_end = $event_end;

        return $this;
    }
}
