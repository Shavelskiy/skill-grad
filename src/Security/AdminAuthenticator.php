<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class AdminAuthenticator extends AbstractFormLoginAuthenticator
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

            if ($user === null || !$user->isActive() || !in_array(User::ROLE_ADMIN, $user->getRoles(), true)) {
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
        /** @var User $user */
        $user = $token->getUser();

        return new JsonResponse(['current_user' => [
            'id' => $user->getId(),
            'username' => $this->getUserUsername($user),
        ]]);
    }

    protected function getUserUsername(User $user): string
    {
        $userInfo = $user->getUserInfo();
        if ($userInfo !== null && $userInfo->getFullName() !== null && !empty($userInfo->getFullName())) {
            return $userInfo->getFullName();
        }

        return $user->getUsername();
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['message' => 'Неверный логин или пароль'], Response::HTTP_UNAUTHORIZED);
    }

    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate('admin.login');
    }
}
