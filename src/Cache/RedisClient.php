<?php

namespace App\Cache;

use Redis;

class RedisClient
{
    protected static Redis $connection;

    public static function getConnection(): Redis
    {
        if (!isset(static::$connection)) {
            $redis = new Redis();
            $redis->connect('redis', 6379);
            static::$connection = $redis;
        }

        return static::$connection;
    }
}
