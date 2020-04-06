<?php

namespace App\Adapter;

use Redis;

class RedisClient
{
    protected static $connection;

    /**
     * @return Redis
     */
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