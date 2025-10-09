<?php

namespace App\Entity;

use App\Enum\Country;
use App\Enum\User_Role;
use App\Enum\User_Status;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "user_id", type: "integer")]
    private ?int $user_id = null;

    #[ORM\Column(length: 50)]
    private ?string $user_name = null;

    #[ORM\Column(length: 100)]
    private ?string $user_email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $user_dob = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true, enumType: Country::class)]
    private ?array $user_country = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: User_Role::class)]
    private array $user_role = [];

    #[ORM\Column(length: 60)]
    private ?string $user_password = null;

    #[ORM\Column]
    private ?int $user_xp = null;

    #[ORM\Column(enumType: User_Status::class)]
    private ?User_Status $user_status = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Event::class, orphanRemoval: true)]
    private Collection $events;

    /**
     * @var Collection<int, ReviewForm>
     */
    #[ORM\OneToMany(mappedBy: 'user',targetEntity: ReviewForm::class)]
    private Collection $reviewForms;

     #[ORM\OneToMany(mappedBy: 'user',targetEntity: TakePartIn::class)]
    private Collection $participations;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->reviewForms = new ArrayCollection();
        $this->participations = new ArrayCollection();
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): static
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $user_email): static
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getUserDob(): ?\DateTime
    {
        return $this->user_dob;
    }

    public function setUserDob(?\DateTime $user_dob): static
    {
        $this->user_dob = $user_dob;

        return $this;
    }

    /**
     * @return Country[]|null
     */
    public function getUserCountry(): ?array
    {
        return $this->user_country;
    }

    public function setUserCountry(?array $user_country): static
    {
        $this->user_country = $user_country;

        return $this;
    }

    /**
     * @return User_Role[]
     */
    public function getUserRole(): array
    {
        return $this->user_role;
    }

    public function setUserRole(array $user_role): static
    {
        $this->user_role = $user_role;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->user_password;
    }

    public function setUserPassword(string $user_password): static
    {
        $this->user_password = $user_password;

        return $this;
    }

    public function getUserXp(): ?int
    {
        return $this->user_xp;
    }

    public function setUserXp(int $user_xp): static
    {
        $this->user_xp = $user_xp;

        return $this;
    }

    public function getUserStatus(): ?User_Status
    {
        return $this->user_status;
    }

    public function setUserStatus(User_Status $user_status): static
    {
        $this->user_status = $user_status;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setUserId($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getUserId() === $this) {
                $event->setUserId(null);
            }
        }

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
            $reviewForm->setUserId($this);
        }

        return $this;
    }

    public function removeReviewForm(ReviewForm $reviewForm): static
    {
        if ($this->reviewForms->removeElement($reviewForm)) {
            // set the owning side to null (unless already changed)
            if ($reviewForm->getUserId() === $this) {
                $reviewForm->setUserId(null);
            }
        }

        return $this;
    }

    public function getParticipations(): Collection
    {
        return $this->participations;
    }
}
