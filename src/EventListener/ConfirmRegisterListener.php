<?php

namespace App\EventListener;

use App\Entity\User;
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

    protected EntityManagerInterface $em;
    protected GuardAuthenticatorHandler $guardHandler;
    protected FlashBagInterface $flashBag;
    protected SessionInterface $session;

    public function __construct(
        EntityManagerInterface $em,
        GuardAuthenticatorHandler $guardHandler,
        FlashBagInterface $flashBag,
        SessionInterface $session
    ) {
        $this->em = $em;
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

    /**
     * @param RequestEvent $event
     */
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

            $token = new PostAuthenticationGuardToken($user, 'main', $user->getRoles());

            $this->guardHandler->authenticateWithToken($token, $request);
            $this->session->set('_security_main', serialize($token));
        } catch (Throwable $e) {
            return;
        }

        $this->flashBag->add('alert.message', 'Ваш аккаунт активирован');
    }
}
