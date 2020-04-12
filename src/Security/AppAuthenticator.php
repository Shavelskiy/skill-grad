<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AppAuthenticator extends AbstractAuthenticator
{
    protected function getLoginRoute(): string
    {
        return self::APP_LOGIN_URL;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new JsonResponse('Вы успешно авторизованы');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $response = [
            'message' => $exception->getMessage(),
            'csrf' => $this->csrfTokenManager->getToken('login')->getValue(),
        ];

        return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
    }
}
