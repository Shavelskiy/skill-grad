<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use App\Entity\Program\Program;
use App\Entity\Provider;
use App\Service\SearchService;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;

class SearchSubscriber implements EventSubscriber
{
    protected SearchService $searchService;

    public function __construct(
        SearchService $searchService
    ) {
        $this->searchService = $searchService;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::onFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $args): void
    {
        $unitOfWork = $args->getEntityManager()->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {
            $this->handleEntityForAdd($entity);
        }

        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity) {
            $this->handleEntityForAdd($entity);
        }

        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
            $this->handleEntityForDelete($entity);
        }
    }

    protected function handleEntityForAdd(object $entity): void
    {
        if ($entity instanceof Article) {
            if ($entity->isActive()) {
                $this->searchService->addArticleToIndex($entity);
            } else {
                $this->searchService->removeArticleFromIndex($entity->getId());
            }
        }

        if ($entity instanceof Provider) {
            $this->searchService->addProviderToIndex($entity);
        }

        if ($entity instanceof Program) {
            if ($entity->isActive()) {
                $this->searchService->addProgramToIndex($entity);
            } else {
                $this->searchService->removeProgramFromIndex($entity->getId());
            }
        }
    }

    protected function handleEntityForDelete(object $entity): void
    {
        if ($entity instanceof Article) {
            $this->searchService->removeArticleFromIndex($entity->getId());
        }

        if ($entity instanceof Provider) {
            $this->searchService->removeProviderFromIndex($entity->getId());
        }

        if ($entity instanceof Program) {
            $this->searchService->removeProgramFromIndex($entity->getId());
        }
    }
}
