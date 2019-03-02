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

    /**
     * {@inheritdoc}
     */
    public function load(string $service)
    {
        // TODO: Implement load() method.
    }

    /**
     * {@inheritdoc}
     */
    public function save(string $service, string $value)
    {
        // TODO: Implement save() method.
    }

    /**
     * {@inheritdoc}
     */
    public function lock(string $service, string $value, int $ttl): ?bool
    {
        return $this->getStorage()->set($service, $value, ['NX', 'PX' => $ttl]);
    }

    /**
     * {@inheritdoc}
     */
    public function unlock(string $service, string $value): ?bool
    {
        // TODO: Implement unlock() method.
    }
}
