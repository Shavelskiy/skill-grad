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

class OkAuth implements SocialAuthInterface
{
    protected const AUTH_URL = 'https://connect.ok.ru/oauth/authorize?';

    protected const API_BASE_URL = 'https://api.ok.ru';
    protected const ACCESS_TOKEN_URL = '/oauth/token.do';
    protected const API_REST_URL = '/fb.do';
    protected const GET_USER_METHOD = 'users.getCurrentUser';

    protected const SOCIAL_KEY = 'ok-auth';

    protected string $clientId;
    protected string $secretKey;
    protected string $publicKey;

    protected string $siteHost;

    public function __construct(ParameterBagInterface $params)
    {
        $okParams = ($params->get('social.services'))['ok'];

        $this->clientId = $okParams['client_id'];
        $this->secretKey = $okParams['secret_key'];
        $this->publicKey = $okParams['public_key'];

        $this->siteHost = ($params->get('site'))['host'];
    }

    public function getAuthLink(): string
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->siteHost,
            'scope' => 'GET_EMAIL',
            'response_type' => 'code',
            'state' => serialize([
                'socialKey' => self::SOCIAL_KEY,
            ]),
        ];

        return self::AUTH_URL . http_build_query($params);
    }

    public function getAlias(): string
    {
        return 'ok';
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
        $accessToken = $this->getUserAccessToken($credentials['code']);

        $params = [
            'application_key' => $this->publicKey,
            'fields' => 'EMAIL',
            'method' => self::GET_USER_METHOD,
        ];

        ksort($params);

        $sign = '';

        foreach ($params as $key => $value) {
            $sign .= "$key=$value";
        }

        $sign .= md5($accessToken . $this->secretKey);
        $sign = md5($sign);

        $params['sig'] = $sign;
        $params['access_token'] = $accessToken;

        $response = $client->request('POST', self::API_BASE_URL . self::API_REST_URL, ['query' => $params]);

        $content = json_decode($response->getContent(), true);

        if (!isset($content['email'])) {
            throw new RuntimeException('Email not found');
        }

        return $content['email'];
    }

    /**
     * @param $code
     *
     * @return string
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function getUserAccessToken($code): string
    {
        $client = HttpClient::create();

        $response = $client->request('POST', self::API_BASE_URL . self::ACCESS_TOKEN_URL, [
            'query' => [
                'code' => $code,
                'client_id' => $this->clientId,
                'client_secret' => $this->secretKey,
                'redirect_uri' => 'http://localhost:8080',
                'grant_type' => 'authorization_code',
            ],
        ]);

        $content = json_decode($response->getContent(), true);

        if (!isset($content['access_token'])) {
            throw new RuntimeException('access_token not found');
        }

        return $content['access_token'];
    }
}
