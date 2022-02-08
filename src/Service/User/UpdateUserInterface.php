<?php

namespace App\Service\User;

use App\Dto\UpdateUserData;
use App\Entity\User;

interface UpdateUserInterface
{
    public function updateUser(User $user, UpdateUserData $updateUserData);
}
