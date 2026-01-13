<?php

namespace App\Entity;

use App\Enum\Country;
use App\Enum\User_Role;
use App\Enum\User_Status;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USER_NAME', fields: ['user_name'])]
#[UniqueEntity(fields: ['user_name'], message: 'There is already an account with this user_name')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "user_id", type: "integer")]
    private ?int $user_id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez compléter ce champ')]
    #[Assert\Length(min: 5, minMessage: 'Votre identifiant doit contenir au minimum {{ limit }} caractères')]
    private ?string $user_name = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(name: "user_role")]
    private array $roles = [];

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Veuillez compléter ce champ')]
    #[Assert\Email(
        message: 'L\'adresse {{ value }} n\'est pas valide.',
    )]
    private ?string $user_email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $user_dob = null;

    #[ORM\Column(nullable: true, enumType: Country::class)]
    private ?Country $user_country = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(name: "user_password")]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $user_xp = 0;

    #[ORM\Column(enumType: User_Status::class)]
    private ?User_Status $user_status = User_status::active;

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

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): static
    {
        $this->user_name = $user_name;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->user_name;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getIfAdmin(): bool
    {
        $is_admin = false;
        if (in_array("ROLE_ADMIN", $this->getRoles())) {
                $is_admin = true;
        }
        return $is_admin;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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
    public function getUserCountry(): ?Country
    {
        return $this->user_country;
    }

    public function setUserCountry(?Country $user_country): static
    {
        $this->user_country = $user_country;

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
            $event->setUser($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getUser() === $this) {
                $event->setUser(null);
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
            $reviewForm->setUser($this);
        }

        return $this;
    }

    public function removeReviewForm(ReviewForm $reviewForm): static
    {
        if ($this->reviewForms->removeElement($reviewForm)) {
            // set the owning side to null (unless already changed)
            if ($reviewForm->getUser() === $this) {
                $reviewForm->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TakePartIn>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(TakePartIn $participation): static
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setUser($this);
        }

        return $this;
    }

    public function removeParticipation(TakePartIn $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getUser() === $this) {
                $participation->setUser(null);
            }
        }

        return $this;
    }
}
