<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "event_id", type: "integer")]
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $event_detail = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $event_max_participants = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "events")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "user_id", nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, ReviewForm>
     */
    #[ORM\OneToMany(targetEntity: ReviewForm::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $reviewForms;

    #[ORM\OneToMany(targetEntity: TakePartIn::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $participants;

    #[ORM\Column]
    private ?bool $event_is_validated = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $event_movie_year = null;

    public function __construct()
    {
        $this->reviewForms = new ArrayCollection();
        $this->participants = new ArrayCollection();
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

    public function getEventDetail(): ?string
    {
        return $this->event_detail;
    }

    public function setEventDetail(?string $event_detail): static
    {
        $this->event_detail = $event_detail;

        return $this;
    }

    public function getEventMaxParticipants(): ?int
    {
        return $this->event_max_participants;
    }

    public function setEventMaxParticipants(int $event_max_participants): static
    {
        $this->event_max_participants = $event_max_participants;

        return $this;
    }

    public function getParticipants(): Collection
{
    return $this->participants;
}

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
    

    /**
     * @return Collection<int, ReviewForm>
     */
    public function getReviewForms(): Collection
    {
        return $this->reviewForms;
    }

    public function addReviewForm(ReviewForm $reviewForm): static
    {
        if (!$this->reviewForms->contains($reviewForm)) {
            $this->reviewForms->add($reviewForm);
            $reviewForm->setEvent($this);
        }

        return $this;
    }

    public function removeReviewForm(ReviewForm $reviewForm): static
    {
        if ($this->reviewForms->removeElement($reviewForm)) {
            // set the owning side to null (unless already changed)
            if ($reviewForm->getEvent() === $this) {
                $reviewForm->setEvent(null);
            }
        }

        return $this;
    }

    public function isEventIsValidated(): ?bool
    {
        return $this->event_is_validated;
    }

    public function setEventIsValidated(bool $event_is_validated): static
    {
        $this->event_is_validated = $event_is_validated;

        return $this;
    }

    public function getEventMovieYear(): ?\DateTime
    {
        return $this->event_movie_year;
    }

    public function getStrEventMovieYear(): ?String
    {
        $str_event_movie_year = $this->event_movie_year->format('Y');
        return $str_event_movie_year;
    }

    public function setEventMovieYear(?\DateTime $event_movie_year): static
    {
        $this->event_movie_year = $event_movie_year;

        return $this;
    }

    public function setIfAutoValidated(?User $user): void
    {
        if (in_array("ROLE_ADMIN", $user->getRoles())) {
                $this->setEventIsValidated(true);
            }
            else {
                $this->setEventIsValidated(false);
            }
    }

    public function checkIfCanDelete(?User $user): bool
    {
        $can_delete = false;
        if (in_array("ROLE_ADMIN", $user->getRoles())) {
                $can_delete = true;
        }
        if ($user == $this->getUser()) {
                $can_delete = true;
        }
        return $can_delete;
    }
}
