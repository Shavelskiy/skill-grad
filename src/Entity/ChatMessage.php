<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatMessageRepository")
 */
class ChatMessage
{
    use IdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recipientId")
     * @ORM\JoinColumn(nullable=false)
     */
    protected User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="chatMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    protected User $recipient;

    /**
     * @ORM\Column(type="text")
     */
    protected string $message;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTimeInterface $dateSend;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $viewed;

    public function __construct()
    {
        $this->viewed = false;
        $this->dateSend = new DateTime();
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

    public function getRecipient(): User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage($message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getDateSend(): DateTimeInterface
    {
        return $this->dateSend;
    }

    public function setDateSend(DateTimeInterface $dateSend): self
    {
        $this->dateSend = $dateSend;
        return $this;
    }

    public function isViewed(): ?bool
    {
        return $this->viewed;
    }

    public function setViewed(bool $viewed): self
    {
        $this->viewed = $viewed;
        return $this;
    }
}
