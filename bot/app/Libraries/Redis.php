<?php

namespace App\Libraries;

class Redis extends \Redis {

    private static $redis;

    /**
     * @param string $selector
     * 
     * @return self
     */
    public static function use(string $selector = 'default'): self {

        $config = config('database.redis.' . $selector);
        self::$redis = new Redis;
        self::$redis->connect($config['host'], $config['port']);
        self::$redis->auth($config['password']);
        self::$redis->select($config['database']);
        return self::$redis;
    }
}