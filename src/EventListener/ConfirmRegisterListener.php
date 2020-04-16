<?php

namespace App\EventListener;

use App\Entity\User;
use App\Security\AbstractAuthenticator;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Throwable;

class ConfirmRegisterListener implements EventSubscriberInterface
{
    public const CONFIRM_REGISTRATION_KEY = 'confirm_register';

    protected EntityManagerInterface $em;
    protected GuardAuthenticatorHandler $guardHandler;
    protected AbstractAuthenticator $authenticator;
    protected FlashBagInterface $flashBag;

    public function __construct(
        EntityManagerInterface $em,
        GuardAuthenticatorHandler $guardHandler,
        AppAuthenticator $authenticator,
        FlashBagInterface $flashBag
    )
    {
        $this->em = $em;
        $this->guardHandler = $guardHandler;
        $this->authenticator = $authenticator;
        $this->flashBag = $flashBag;
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

            $user = $this->em->getRepository(User::class)->findByRegisterToken($request->get('token'));

            $user
                ->setActive(true)
                ->resetRegisterToken();

            $this->em->persist($user);
            $this->em->flush();

            $this->guardHandler->authenticateUserAndHandleSuccess($user, $request, $this->authenticator, 'main');
        } catch (Throwable $e) {
            return;
        }

        $this->flashBag->add('alert.message', 'Ваш аккаунт активирован');
    }
}
