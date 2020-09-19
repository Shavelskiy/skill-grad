<?php

namespace App\EventSubscriber;

use App\Entity\UserToken;
use App\Repository\UserTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use Throwable;

class ConfirmRegisterListener implements EventSubscriberInterface
{
    public const CONFIRM_REGISTRATION_KEY = 'confirm_register';

    protected EntityManagerInterface $entityManager;
    protected UserTokenRepository $userTokenRepository;
    protected GuardAuthenticatorHandler $guardHandler;
    protected FlashBagInterface $flashBag;
    protected SessionInterface $session;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserTokenRepository $userTokenRepository,
        GuardAuthenticatorHandler $guardHandler,
        FlashBagInterface $flashBag,
        SessionInterface $session
    ) {
        $this->entityManager = $entityManager;
        $this->userTokenRepository = $userTokenRepository;
        $this->guardHandler = $guardHandler;
        $this->flashBag = $flashBag;
        $this->session = $session;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $this->flashBag->get('alert.message');

        try {
            $request = $event->getRequest();

            if (!(bool)$request->get(self::CONFIRM_REGISTRATION_KEY)) {
                throw new RuntimeException('event not available');
            }

            $userToken = $this->userTokenRepository->findByTokenAndType($request->get('token'), UserToken::TYPE_REGISTER);

            $user = $userToken->getUser();

            $user->setActive(true);

            $this->entityManager->persist($user);
            $this->entityManager->remove($userToken);
            $this->entityManager->flush();

            $token = new PostAuthenticationGuardToken($user, 'main', $user->getRoles());

            $this->guardHandler->authenticateWithToken($token, $request);
            $this->session->set('_security_main', serialize($token));
        } catch (Throwable $e) {
            return;
        }

        $this->flashBag->add('alert.message', 'Ваш аккаунт активирован');
    }
}
