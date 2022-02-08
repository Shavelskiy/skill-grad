<?php

namespace App\EventListener;

use App\Enum\Cache\Relations;
use App\Helpers\MemcachedClient;
use Doctrine\ORM\Event\OnFlushEventArgs;
use ErrorException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Exception\CacheException;

class EntityCacheListener
{
    /**
     * @throws ErrorException
     * @throws CacheException
     * @throws InvalidArgumentException
     */
    public function onFlush(OnFlushEventArgs $eventArgs): void
    {
        $entityClasses = [];

        $uow = $eventArgs->getEntityManager()->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entityUpdate) {
            $entityClasses[] = get_class($entityUpdate);
        }

        foreach ($uow->getScheduledEntityInsertions() as $entityInsertion) {
            $entityClasses[] = get_class($entityInsertion);
        }

        foreach ($uow->getScheduledEntityDeletions() as $entityDeletion) {
            $entityClasses[] = get_class($entityDeletion);
        }

        $keysToClear = [];

        foreach ($entityClasses as $entityClass) {
            if (!array_key_exists($entityClass, Relations::ENTITY)) {
                continue;
            }

            $keysToClear = [...$keysToClear, ...Relations::ENTITY[$entityClass]];
        }

        if (empty($keysToClear)) {
            return;
        }

        $cache = MemcachedClient::getCache();

        foreach ($keysToClear as $keyToClear) {
            $cache->delete($keyToClear);
        }
    }
}
