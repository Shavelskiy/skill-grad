<?php

namespace App\Dto;

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

    protected string $oldPassword;
    protected string $newPassword;
    protected string $confirmNewPassword;

    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return UpdateUserData
     */
    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return UpdateUserData
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return UpdateUserData
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    /**
     * @return UpdateUserData
     */
    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    /**
     * @return UpdateUserData
     */
    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    public function getConfirmNewPassword(): string
    {
        return $this->confirmNewPassword;
    }

    /**
     * @return UpdateUserData
     */
    public function setConfirmNewPassword(string $confirmNewPassword): self
    {
        $this->confirmNewPassword = $confirmNewPassword;
        return $this;
    }
}
