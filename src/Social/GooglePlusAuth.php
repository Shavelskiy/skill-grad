<?php

namespace App\Social;

use RuntimeException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GooglePlusAuth implements SocialAuthInterface
{
    public function __construct()
    {
    }

    public function getAuthLink(): string
    {
        return '#';
    }

    public function getAlias(): string
    {
        return 'plus';
    }

    public function support(Request $request): bool
    {
        return false;
    }

    public function getCredentials(Request $request): array
    {
        return [];
    }

    /**
     * @param $credentials
     *
     * @return string
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getUserEmail($credentials): string
    {
        return '';
    }
}
