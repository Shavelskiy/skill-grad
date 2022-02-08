<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class AdminAuthenticator extends AbstractGuardAuthenticator
{
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
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request): bool
    {
        return 'admin.login' === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    public function getCredentials(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        return [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $user = $this->userRepository->findUserByEmail($credentials['email']);

            if (!$user->isActive() || !in_array(User::ROLE_ADMIN, $user->getRoles(), true)) {
                return null;
            }

            return $user;
        } catch (Exception $e) {
            return null;
        }
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            throw new RuntimeException('user is not object of user class');
        }

        return new JsonResponse(['current_user' => [
            'id' => $user->getId(),
            'username' => $this->getUserUsername($user),
        ]]);
    }

    protected function getUserUsername(User $user): string
    {
        $userInfo = $user->getUserInfo();
        if ($userInfo !== null && !empty($userInfo->getFullName())) {
            return $userInfo->getFullName();
        }

        return $user->getUsername();
    }

    public function supportsRememberMe(): bool
    {
        return true;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse($this->urlGenerator->generate('admin.login'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new JsonResponse(['message' => 'Неверный логин или пароль'], Response::HTTP_UNAUTHORIZED);
    }
}
