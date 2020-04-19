<?php

namespace App\Social;

use RuntimeException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class OkAuth implements SocialAuthInterface
{
    protected const AUTH_URL = 'https://connect.ok.ru/oauth/authorize?';
    protected const ACCESS_TOKEN_URL = 'https://oauth.vk.com/access_token';

    protected const SOCIAL_KEY = 'ok-auth';

    protected string $clientId;
    protected string $secretKey;

    public function __construct()
    {
        $this->clientId = '512000359268';
        $this->secretKey = '43EB8875CCEF2F10D38AC5AB';
    }

    public function getAuthLink(bool $create = false): string
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => 'http://localhost:8080',
            'scope' => 'friends,email',
            'response_type' => 'code',
            'state' => serialize([
                'socialKey' => self::SOCIAL_KEY,
                'create' => $create,
            ]),
        ];

        return self::AUTH_URL . http_build_query($params);
    }

    public function support(Request $request): bool
    {
        $state = unserialize($request->get('state'));

        if ($state === false) {
            return false;
        }

        return in_array(self::SOCIAL_KEY, $state, true);
    }

    public function getCredentials(Request $request): array
    {
        $state = unserialize($request->get('state'));

        return [
            'code' => $request->query->get('code'),
            'create' => ($state !== false && ((bool)$state['create'])),
            'socialKey' => self::SOCIAL_KEY,
        ];
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
        $client = HttpClient::create();

        $response = $client->request('GET', self::ACCESS_TOKEN_URL, [
            'query' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->secretKey,
                'redirect_uri' => 'http://localhost:8080',
                'code' => $credentials['code'],
            ],
        ]);

        $content = json_decode($response->getContent(), true);

        if (!isset($content['email'])) {
            throw new RuntimeException('Email not found');
        }

        return $content['email'];
    }
}
