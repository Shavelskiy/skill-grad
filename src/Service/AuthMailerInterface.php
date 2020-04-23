<?php

namespace App\Service;

interface AuthMailerInterface
{
    public function sendResetPasswordEmail($toEmail, $token);
}
