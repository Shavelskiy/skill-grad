<?php

namespace App\Service;

interface RegisterUserInterface
{
    public function registerUser(string $email, string $password, bool $isProvider): void;
}
