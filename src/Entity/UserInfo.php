<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class UserInfo
{
    use IdTrait;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="userInfo", cascade={"persist", "remove"})
     */
    protected User $user;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    protected ?string $fullName;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    protected ?string $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected ?string $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="users")
     */
    protected ?Category $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Upload")
     */
    protected ?Upload $image;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->fullName ?? '';
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getImage(): ?Upload
    {
        return $this->image;
    }

    public function setImage(?Upload $image): self
    {
        $this->image = $image;
        return $this;
    }
}
