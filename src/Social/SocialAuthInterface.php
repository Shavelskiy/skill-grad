<?php

namespace App\Social;

use Symfony\Component\HttpFoundation\Request;

interface SocialAuthInterface
{
    public function getAuthLink(bool $create): string;

    public function support(Request $request): bool;

    public function getCredentials(Request $request): array;

    public function getUserEmail($credentials): string;
}
