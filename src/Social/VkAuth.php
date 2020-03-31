<?php

namespace App\Social;

use RuntimeException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class VkAuth implements SocialAuthInterface
{
    protected const AUTH_URL = 'https://oauth.vk.com/authorize?';
    protected const ACCESS_TOKEN_URL = 'https://oauth.vk.com/access_token';

    protected const CLIENT_ID = '7351839';
    protected const SECRET_KEY = '0raiFV7o7ZRetkxUnzWJ';

    protected const AUTH_KEY = 'vk-auth';

    public function getAuthLink(): string
    {
        $params = [
            'client_id' => self::CLIENT_ID,
            'redirect_uri' => 'http://localhost:8080',
            'scope' => 'friends,email',
            'response_type' => 'code',
            'state' => self::AUTH_KEY,
        ];

        return self::AUTH_URL . http_build_query($params);
    }

    public function support(Request $request): bool
    {
        return ($request->query->get('state') === self::AUTH_KEY);
    }

    public function getCredentials(Request $request): array
    {
        return [
            'code' => $request->query->get('code'),
        ];
    }

    /**
     * @param $credentials
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getUserEmail($credentials): string
    {
        $client = HttpClient::create();

        $response = $client->request('GET', self::ACCESS_TOKEN_URL, [
            'query' => [
                'client_id' => self::CLIENT_ID,
                'client_secret' => self::SECRET_KEY,
                'redirect_uri' => 'http://localhost:8080',
                'code' => $credentials['code']
            ],
        ]);

        $content = json_decode($response->getContent(), true);

        if (!isset($content['email'])) {
            throw new RuntimeException('Email not found');
        }

        return $content['email'];
    }
}
