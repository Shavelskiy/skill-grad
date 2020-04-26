<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
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
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private ?string $phone;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $active = false;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private ?string $fullName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $about;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private ?string $specialization;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string")
     */
    private ?string $password;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Upload")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?string $avatar;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $socialKey;

    /**
     * @ORM\Column(type="uuid", unique=true, nullable=true)
     */
    private ?UuidInterface $chatToken;

    /**
     * @ORM\Column(type="uuid", unique=true, nullable=true)
     */
    private ?UuidInterface $resetPasswordToken;

    /**
     * @ORM\Column(type="uuid", unique=true, nullable=true)
     */
    protected ?UuidInterface $registerToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    public function setUsername(string $username): self
    {
        $this->email = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return User
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return User
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return User
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @param string|null $fullName
     * @return User
     */
    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @see UserInterface
     */
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

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getChatToken(): UuidInterface
    {
        return $this->chatToken;
    }

    /**
     * @return User
     */
    public function generateChatToken(): self
    {
        $this->chatToken = Uuid::uuid4();

        return $this;
    }

    /**
     * @return UuidInterface
     */
    public function getResetPasswordToken(): UuidInterface
    {
        return $this->resetPasswordToken;
    }

    /**
     * @return User
     */
    public function generateResetPasswordToken(): self
    {
        $this->resetPasswordToken = Uuid::uuid4();
        return $this;
    }

    public function resetResetPasswordToken(): self
    {
        $this->resetPasswordToken = null;
        return $this;
    }

    /**
     * @return UuidInterface
     */
    public function getRegisterToken(): UuidInterface
    {
        return $this->registerToken;
    }

    /**
     * @return User
     */
    public function generateRegisterToken(): self
    {
        $this->registerToken = Uuid::uuid4();
        return $this;
    }

    public function resetRegisterToken(): self
    {
        $this->registerToken = null;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSocialKey(): ?string
    {
        return $this->socialKey;
    }

    /**
     * @param string|null $socialKey
     * @return User
     */
    public function setSocialKey(?string $socialKey): self
    {
        $this->socialKey = $socialKey;
        return $this;
    }
}
