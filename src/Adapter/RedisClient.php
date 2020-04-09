<?php

namespace App\Adapter;

use Redis;

class RedisClient
{
    protected static Redis $connection;

    public static function getConnection(): Redis
    {
        if (static::$connection === null) {
            $redis = new Redis();
            $redis->connect('redis', 6379);
            static::$connection = $redis;
        }

        return static::$connection;
    }
}
