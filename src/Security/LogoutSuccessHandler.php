<?php

namespace App\Security;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    protected const ADMIN_KEY = 'from_admin';

    /** @var HttpUtils */
    protected $httpUtils;

    /** @var Router */
    protected $router;

    public function __construct(HttpUtils $httpUtils, Router $router)
    {
        $this->httpUtils = $httpUtils;
        $this->router = $router;
    }

    public function onLogoutSuccess(Request $request)
    {
        if ((bool)$request->get(self::ADMIN_KEY)) {
            return $this->httpUtils->createRedirectResponse($request, $this->router->generate('admin.site.login'));
        }

        return $this->httpUtils->createRedirectResponse($request, $this->router->generate('site.index'));
    }
}
