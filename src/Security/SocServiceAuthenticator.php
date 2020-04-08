<?php

namespace App\Security;

use App\Entity\User;
use App\Social\SocialAuthFactory;
use App\Social\SocialAuthInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class SocServiceAuthenticator extends AbstractFormLoginAuthenticator
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var SocialAuthInterface */
    protected $socialAuthService;

    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request): bool
    {
        $socialAuthFactory = new SocialAuthFactory();

        /** @var SocialAuthInterface $service */
        foreach ($socialAuthFactory->getServices() as $service) {
            if ($service->support($request)) {
                $this->socialAuthService = $service;

                return true;
            }
        }

        return false;
    }

    public function getCredentials(Request $request): array
    {
        return $this->socialAuthService->getCredentials($request);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $userEmail = $this->socialAuthService->getUserEmail($credentials);
        } catch (Exception $e) {
            return null;
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $userEmail]);

        if (!$user) {
            $user = (new User())->setUsername($userEmail);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user, '123456')
            );
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

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
