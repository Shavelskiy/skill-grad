<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRequestRepository")
 */
class ProgramRequest
{
    public const STATUS_NEW = 'new';
    public const STATUS_AGREE = 'agree';
    public const STATUS_REJECT = 'reject';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program")
     */
    private Program $program;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private string $comment;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $status;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $rejectReason;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $updated;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

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

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getRejectReason(): string
    {
        return $this->rejectReason;
    }

    public function setRejectReason(string $rejectReason): void
    {
        $this->rejectReason = $rejectReason;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    public function setUpdated(DateTime $updated): void
    {
        $this->updated = $updated;
    }
}
