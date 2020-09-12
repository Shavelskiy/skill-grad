<?php

namespace App\Entity\Program;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRequestRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProgramRequest
{
    use IdTrait;
    use TimestampTrait;

    public const STATUS_NEW = 'new';
    public const STATUS_AGREE = 'agree';
    public const STATUS_REJECT = 'reject';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program", inversedBy="requests")
     */
    protected Program $program;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected string $comment;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected string $status;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $rejectReason;

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

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getRejectReason(): string
    {
        return $this->rejectReason;
    }

    public function setRejectReason(string $rejectReason): self
    {
        $this->rejectReason = $rejectReason;
        return $this;
    }
}
