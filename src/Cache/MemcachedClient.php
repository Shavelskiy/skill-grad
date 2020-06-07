<?php

namespace App\Cache;

use ErrorException;
use Memcached;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Cache\Exception\CacheException;

class MemcachedClient
{
    protected static Memcached $connection;

    /**
     * @return MemcachedAdapter
     * @throws ErrorException
     * @throws CacheException
     */
    public static function getCache(): MemcachedAdapter
    {
        $client = MemcachedAdapter::createConnection('memcached://memcached');

        return new MemcachedAdapter($client);
    }
}
