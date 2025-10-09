<?php

namespace App\Entity;

use App\Enum\ReviewNote;
use App\Repository\ReviewFormRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewFormRepository::class)]
class ReviewForm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "review_id", type: "integer")]
    private ?int $review_id = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: ReviewNote::class)]
    private ?array $review_note = [];

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $review_body = null;

    #[ORM\ManyToOne(inversedBy: 'reviewForms')]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "user_id", nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reviewForms')]
     #[ORM\JoinColumn(name: "event_id", referencedColumnName: "event_id", nullable: false)]
    private ?Event $event = null;

    public function getReviewId(): ?int
    {
        return $this->review_id;
    }

    public function setReviewId(int $review_id): static
    {
        $this->review_id = $review_id;

        return $this;
    }

    public function getReviewNote(): ?ReviewNote
    {
        return $this->review_note;
    }

    public function setReviewNote(ReviewNote $review_note): static
    {
        $this->review_note = $review_note;

        return $this;
    }

    public function getReviewBody(): ?string
    {
        return $this->review_body;
    }

    public function setReviewBody(?string $review_body): static
    {
        $this->review_body = $review_body;

        return $this;
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }
}
