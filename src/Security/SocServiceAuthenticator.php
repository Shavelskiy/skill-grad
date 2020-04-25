<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\RegisterUserInterface;
use App\Social\SocialAuthFactory;
use App\Social\SocialAuthInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        UserRepository $userRepository,
        RegisterUserInterface $registerUserService
    )
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
        $this->registerUserService = $registerUserService;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool
    {
        try {
            $this->socialAuthService = (new SocialAuthFactory())->getSocialAuthForRequest($request);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getCredentials(Request $request): array
    {
        return $this->socialAuthService->getCredentials($request);
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return User|UserInterface|null
     */
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
            if (!$credentials['create']) {
                return null;
            }

            $user = $this->registerUserService->createSocialUser($userEmail, $credentials['socialKey']);
        }

        return $user;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return RedirectResponse|Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->urlGenerator->generate('site.index'));
    }

    /**
     * @return string
     */
    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate('site.index');
    }
}
