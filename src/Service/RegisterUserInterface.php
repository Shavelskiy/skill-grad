<?php

namespace App\Service;

use App\Entity\User;

interface RegisterUserInterface
{
    public function registerUser(string $email, string $password, bool $isProvider): void;

    public function createSocialUser(string $userEmail, string $socialKey): User;
}
