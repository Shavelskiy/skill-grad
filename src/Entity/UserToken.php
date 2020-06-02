<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserTokenRepository")
 */
class UserToken
{
    public const TYPE_CHAT = 'TYPE_CHAT';
    public const TYPE_RESET_PASSWORD = 'TYPE_RESET_PASSWORD';
    public const TYPE_REGISTER = 'TYPE_REGISTER';

    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="id")
     */
    private User $user;

    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    private UuidInterface $token;

    /**
     * @ORM\Column(type="string")
     */
    private string $type;


    public function __construct(string $type)
    {
        $this->type = $type;
        $this->token = Uuid::uuid4();
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

    public function getToken(): UuidInterface
    {
        return $this->token;
    }

    public function setToken(UuidInterface $token): void
    {
        $this->token = $token;
    }
}