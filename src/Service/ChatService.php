<?php

namespace App\Service;

use App\Entity\User;
use Exception;
use RuntimeException;

class ChatService
{

    public function getUserPhoto(User $user): string
    {
        try {
            if (in_array(User::ROLE_PROVIDER, $user->getRoles(), true)) {
                if (($provider = $user->getProvider()) === null) {
                    throw new RuntimeException('');
                }

                if ($provider->getImage() === null) {
                    throw new RuntimeException('');
                }

                return $provider->getImage()->getPublicPath();
            }

            if (($userInfo = $user->getUserInfo()) === null) {
                throw new RuntimeException('');
            }

            if ($userInfo->getImage() === null) {
                throw new RuntimeException('');
            }
        } catch (Exception $e) {
            return '/img/svg/user-no-photo.svg';
        }

        return $userInfo->getImage()->getPublicPath();
    }
}
