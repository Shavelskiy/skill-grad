<?php

namespace App\Service;

interface ResetUserPasswordInterface
{
    public function initResetUserPassword(string $email);

    public function resetUserPassword(string $token, string $newPassword);
}