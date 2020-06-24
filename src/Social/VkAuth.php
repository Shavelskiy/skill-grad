<?php

namespace App\Social;

use RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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

    protected const SOCIAL_KEY = 'vk-auth';

    protected string $clientId;
    protected string $secretKey;

    protected string $siteHost;

    public function __construct(ParameterBagInterface $params)
    {
        $vkParams = ($params->get('social.services'))['vk'];

        $this->clientId = $vkParams['client_id'];
        $this->secretKey = $vkParams['secret_key'];

        $this->siteHost = ($params->get('site'))['host'];
    }

    public function getAuthLink(): string
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->siteHost,
            'scope' => 'friends,email',
            'response_type' => 'code',
            'state' => serialize([
                'socialKey' => self::SOCIAL_KEY,
            ]),
        ];

        return self::AUTH_URL . http_build_query($params);
    }

    public function getAlias(): string
    {
        return 'vk';
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
        return [
            'code' => $request->query->get('code'),
            'socialKey' => self::SOCIAL_KEY,
        ];
    }

    /**
     * @param $credentials
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
