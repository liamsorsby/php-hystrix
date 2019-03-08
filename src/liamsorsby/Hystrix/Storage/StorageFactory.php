<?php

namespace liamsorsby\Hystrix\Storage;

use Cache\Adapter\Apcu\ApcuCachePool;
use Cache\Adapter\Redis\RedisCachePool;
use liamsorsby\Hystrix\Storage\Adapter\AbstractStorage;
use liamsorsby\Hystrix\Storage\Adapter\Apc;
use liamsorsby\Hystrix\Storage\Adapter\RedisCluster;

class StorageFactory
{
    public const RedisCluster = 'redis-cluster';
    public const APCU = 'apcu';

    /**
     * Creates storage from static factory method
     *
     * @param string $storage
     * @param array $options
     *
     * @throws \RedisClusterException
     *
     * @return AbstractStorage
     */
    public function create(string $storage, array $options): AbstractStorage
    {
        switch ($storage) {
            case self::RedisCluster:
                return $this->createRedisClusterAdapter($options);
            case self::APCU:
                return $this->createApcuAdapter($options);
            default:
                throw new \InvalidArgumentException(sprintf('Invalid storage provided: %s', $storage));
        };
    }

    /**
     * Create Redis Cluster Adapter.
     *
     * @param array $options
     *
     * @throws \RedisClusterException
     *
     * @return RedisCluster
     */
    public function createRedisClusterAdapter(array $options): RedisCluster
    {
        $storage = new RedisCluster();

        $storage->setStorage(
            $this->createRedisCluster($options)
        );

        return $storage;
    }

    /**
     * Build Redis Cluster Config
     *
     * @param array $options
     *
     * @throws \RedisClusterException
     *
     * @return RedisCachePool
     */
    public function createRedisCluster(array $options): RedisCachePool
    {
        $redis = new \RedisCluster(
            $options['name'],
            $options['seeds'],
            $options['timeout'] ?? null,
            $options['readTimeout'] ?? null,
            $options['persistent'] ?? false
        );

        return new RedisCachePool($redis);
    }

    /**
     * Build APC instance.
     *
     * @param array $options
     *
     * @return Apc
     */
    public function createApcuAdapter(array $options): Apc
    {
        $apc = new Apc();
        $apc->setStorage(new ApcuCachePool($options['skipOnCli'] ?? false));

        return $apc;
    }
}
