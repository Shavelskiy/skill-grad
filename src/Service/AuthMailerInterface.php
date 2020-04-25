<?php

namespace App\Service;

interface AuthMailerInterface
{
    public function sendResetPasswordEmail(string $toEmail, string $token);

    public function sendRegisterEmail(string $toEmail, string $token);
}
