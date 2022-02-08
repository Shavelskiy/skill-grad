<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\User\RegisterUserInterface;
use App\Social\SocialAuthFactory;
use App\Social\SocialAuthInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class SocServiceAuthenticator extends AbstractFormLoginAuthenticator
{
    protected EntityManagerInterface $entityManager;
    protected UrlGeneratorInterface $urlGenerator;
    protected SocialAuthInterface $socialAuthService;
    protected UserRepository $userRepository;
    protected RegisterUserInterface $registerUserService;
    protected SocialAuthFactory $socialAuthFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        UserRepository $userRepository,
        RegisterUserInterface $registerUserService,
        SocialAuthFactory $socialAuthFactory
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
        $this->registerUserService = $registerUserService;
        $this->socialAuthFactory = $socialAuthFactory;
    }

    public function supports(Request $request): bool
    {
        try {
            $this->socialAuthService = $this->socialAuthFactory->getSocialAuthForRequest($request);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getCredentials(Request $request): array
    {
        return $this->socialAuthService->getCredentials($request);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $userEmail = $this->socialAuthService->getUserEmail($credentials);
        } catch (Exception $exception) {
            return null;
        }

        try {
            $user = $this->userRepository->findUserByEmailAndSocialKey($userEmail, $credentials['socialKey']);
        } catch (Exception $e) {
            $user = $this->registerUserService->createSocialUser($userEmail, $credentials['socialKey']);
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->urlGenerator->generate('site.index'));
    }

    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate('site.index');
    }
}
