<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class UserInfo
{
    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private User $user;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private ?string $fullName;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private ?string $phone;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }
}
