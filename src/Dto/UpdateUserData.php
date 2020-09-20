<?php

namespace App\Dto;

use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserData
{
    /**
     * @Assert\NotBlank()
     */
    protected string $fullName;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected string $email;

    /**
     * @Assert\NotBlank()
     */
    protected string $phone;

    protected string $description;
    protected ?Category $category;

    protected string $oldPassword;
    protected string $newPassword;
    protected string $confirmNewPassword;

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category ?? null;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    public function getConfirmNewPassword(): string
    {
        return $this->confirmNewPassword;
    }

    public function setConfirmNewPassword(string $confirmNewPassword): self
    {
        $this->confirmNewPassword = $confirmNewPassword;
        return $this;
    }
}
