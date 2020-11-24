<?php

namespace App\EventSubscriber;

use App\Repository\LocationRepository;
use App\Service\LocationService;
use RuntimeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocationSubscriber implements EventSubscriberInterface
{
    protected LocationService $locationService;
    protected LocationRepository $locationRepository;

    public function __construct(
        LocationService $locationService,
        LocationRepository $locationRepository
    ) {
        $this->locationService = $locationService;
        $this->locationRepository = $locationRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        preg_match('/^([^.]*).([^.]*).(.*)/', $event->getRequest()->getHost(), $match);

        if (empty($match[3])) {
            // todo без поддомена зашел
        }

        if (($location = $this->locationRepository->findOneBy(['code' => $match[1]])) !== null) {
            $this->locationService->setCurrentLocation($location);
            return;
        }

        // todo ip detect

        if (($location = $this->locationRepository->findOneBy(['code' => LocationService::DEFAULT_LOCATION_CODE])) !== null) {
            $this->locationService->setCurrentLocation($location);
            return;
        }

        throw new RuntimeException(sprintf('error while detect selected location. Host - %s', $event->getRequest()->getHost()));
    }
}
