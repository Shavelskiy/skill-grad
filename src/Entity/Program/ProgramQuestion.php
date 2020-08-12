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
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program")
     */
    protected Program $program;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected string $question;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $answer;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getProgram(): Program
    {
        return $this->program;
    }

    public function setProgram(Program $program): void
    {
        $this->program = $program;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }
}
