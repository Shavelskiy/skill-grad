<?php

namespace App\Entity\Program;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramQuestionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProgramQuestion
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="programQuestions")
     * @ORM\JoinColumn(nullable=false)
     */
    protected User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program", inversedBy="questions")
     */
    protected Program $program;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected string $question;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $answer;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getProgram(): Program
    {
        return $this->program;
    }

    public function setProgram(Program $program): self
    {
        $this->program = $program;
        return $this;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;
        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;
        return $this;
    }
}
