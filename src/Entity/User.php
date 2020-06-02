<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_PROVIDER = 'ROLE_PROVIDER';
    public const ROLE_SEO_MANAGER = 'ROLE_SEO_MANAGER';
    public const ROLE_REDACTOR = 'ROLE_REDACTOR';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $active = false;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string")
     */
    private ?string $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $socialKey;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserInfo", mappedBy="user")
     */
    private UserInfo $userInfo;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return (string)$this->email;
    }

    public function setUsername(string $username): self
    {
        $this->email = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getSocialKey(): ?string
    {
        return $this->socialKey;
    }

    public function setSocialKey(?string $socialKey): self
    {
        $this->socialKey = $socialKey;
        return $this;
    }

    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo ?? null;
    }

    public function setUserInfo(UserInfo $userInfo): self
    {
        $this->userInfo = $userInfo;
        return $this;
    }
}
