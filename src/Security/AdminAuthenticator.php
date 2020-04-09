<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AdminAuthenticator extends AbstractAuthenticator
{
    protected function getLoginRoute(): string
    {
        return self::ADMIN_LOGIN_URL;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->urlGenerator->generate('admin.site.index'));
    }
}
