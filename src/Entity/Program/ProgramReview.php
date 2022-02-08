<?php

namespace App\Entity\Program;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ProgramReview
{
    use IdTrait;
    use TimestampTrait;

    public const RATING_PROGRAM = 'program';
    public const RATING_TEACHER = 'teacher';
    public const RATING_ORGANIZATION = 'organization';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program", inversedBy="reviews")
     */
    protected Program $program;

    /**
     * @ORM\Column(type="text")
     */
    protected string $review;

    /**
     * @ORM\Column(type="json")
     */
    protected array $rating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="programReviews")
     */
    protected User $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected ?string $answer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private ?User $answerUser;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected ?DateTime $answerDate;

    public function getProgram(): Program
    {
        return $this->program;
    }

    public function setProgram(Program $program): self
    {
        $this->program = $program;
        return $this;
    }

    public function getReview(): string
    {
        return $this->review;
    }

    public function setReview(string $review): self
    {
        $this->review = $review;
        return $this;
    }

    public function getRating(): array
    {
        return $this->rating;
    }

    public function setRating(array $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;
        $this->answerDate = new DateTime();
        return $this;
    }

    public function getAnswerUser(): ?User
    {
        return $this->answerUser;
    }

    public function setAnswerUser(?User $answerUser): self
    {
        $this->answerUser = $answerUser;
        return $this;
    }

    public function getAnswerDate(): ?DateTime
    {
        return $this->answerDate;
    }

    public function getAverageRating(): float
    {
        $result = 0;
        $valuesCount = 0;

        foreach ($this->getRating() as $values) {
            foreach ($values as $value) {
                ++$valuesCount;
                $result += $value;
            }
        }

        return round($result / $valuesCount * 10) / 10;
    }
}
