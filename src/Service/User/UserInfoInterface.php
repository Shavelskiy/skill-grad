<?php

namespace App\Service\User;

use App\Entity\User;

interface UserInfoInterface
{
    public function getUsername(?User $user): string;

    public function getUserPhoto(?User $user): string;
}
