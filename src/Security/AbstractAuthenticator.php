<?php

namespace App\Security;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

abstract class AbstractAuthenticator extends AbstractFormLoginAuthenticator
{
    protected const APP_LOGIN_URL = 'ajax.auth.login';
    protected const ADMIN_LOGIN_URL = 'admin.login';

    protected EntityManagerInterface $entityManager;
    protected UrlGeneratorInterface $urlGenerator;
    protected CsrfTokenManagerInterface $csrfTokenManager;
    protected UserPasswordEncoderInterface $passwordEncoder;
    protected UserRepository $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

    abstract protected function getLoginRoute();

    public function supports(Request $request): bool
    {
        return $this->getLoginRoute() === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    public function getCredentials(Request $request): array
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];

        $request->getSession()->set(Security::LAST_USERNAME, $credentials['email']);

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('login', $credentials['csrf_token']))) {
            throw new InvalidCsrfTokenException('');
        }

        return $this->userRepository->findUserByEmail($credentials['email']);
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $user->isActive() && $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate($this->getLoginRoute());
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     *
     * @return RedirectResponse
     */
    public function start(Request $request, AuthenticationException $authException = null): ?RedirectResponse
    {
        $route = (stripos($request->attributes->get('_route'), 'admin.') === 0)
            ? self::ADMIN_LOGIN_URL : self::APP_LOGIN_URL;

        return new RedirectResponse($this->urlGenerator->generate($route));
    }
}
