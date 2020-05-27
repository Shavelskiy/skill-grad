<?php

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AdminAccessDeniedListener
{
    protected Router $urlGenerator;

    public function __construct(Router $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof AccessDeniedHttpException) {
            return;
        }

        [$controller, $method] = explode('::', $event->getRequest()->attributes->get('_controller'));
        $controllerClass = new $controller();

//        if (!$controllerClass instanceof AdminAbstractController) {
            return;
//        }

        $event->setResponse(
            new RedirectResponse($this->urlGenerator->generate('admin.site.login'))
        );
    }
}
