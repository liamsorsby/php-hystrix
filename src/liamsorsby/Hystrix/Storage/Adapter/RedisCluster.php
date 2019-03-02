<?php

namespace liamsorsby\Hystrix\Storage\Adapter;

use \RedisCluster as Redis;

class RedisCluster extends AbstractStorage
{
    /**
     * Assigns the redis object to the storage.
     *
     * @param Redis $redis
     *
     * @return void
     */
    public function createConnection(Redis $redis) :void
    {
        $this->storage = $redis;
    }

    /**
     * Get storage object.
     *
     * @return Redis
     */
    public function getStorage() :Redis
    {
        return $this->storage;
    }
}
