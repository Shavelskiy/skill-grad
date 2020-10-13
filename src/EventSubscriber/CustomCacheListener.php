<?php

namespace App\EventSubscriber;

use App\Entity\Program\ProgramReview;
use App\Enum\Cache\Keys;
use App\Helpers\MemcachedClient;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use ErrorException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Exception\CacheException;

class CustomCacheListener implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::onFlush,
        ];
    }

    /**
     * @throws ErrorException
     * @throws CacheException
     * @throws InvalidArgumentException
     */
    public function onFlush(OnFlushEventArgs $eventArgs): void
    {
        $unitOfWork = $eventArgs->getEntityManager()->getUnitOfWork();

        $programReviews = [];

        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof ProgramReview) {
                $programReviews[] = $entity;
            }
        }

        $cache = MemcachedClient::getCache();

        /** @var ProgramReview $programReview */
        foreach ($programReviews as $programReview) {
            $cache->delete(sprintf('%s_%s',
                    Keys::PROGRAM_AVERAGE_REVIEW,
                    $programReview->getProgram()->getId())
            );
        }
    }
}
