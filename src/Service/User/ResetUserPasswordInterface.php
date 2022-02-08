<?php

namespace App\Service\User;

interface ResetUserPasswordInterface
{
    public function initResetUserPassword(string $email);

    public function resetUserPassword(string $token, string $newPassword);
}
