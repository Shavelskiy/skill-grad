<?php

namespace App\Service;

use App\Dto\UpdateUserData;
use App\Entity\User;

interface UpdateUserInterface
{
    public function updateUser(User $user, UpdateUserData $updateUserData);
}
