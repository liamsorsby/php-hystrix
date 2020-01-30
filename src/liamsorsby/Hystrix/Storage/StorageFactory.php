<?php

/**
 * StorageFactory for storage adapter for php-hystrix.
 *
 * PHP version 7.2
 *
 * @category Adapter
 * @package  Storage
 * @author   Liam Sorsby <liam.sorsby@sky.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache
 * @link     https://github.org/liamsorsby/php-hystrix
 *
 * For the full copyright and license information, please view the LICENSE file.
 */

namespace liamsorsby\Hystrix\Storage;

use liamsorsby\Hystrix\Storage\Adapter\{
    AbstractStorage,
    Apc,
    Memcached,
    RedisCluster,
    Redis,
    RedisArray
};

/**
 * Class StorageFactory
 *
 * @category Adapter
 * @package  Storage
 * @author   Liam Sorsby <liam.sorsby@sky.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache
 * @link     https://github.org/liamsorsby/php-hystrix
 */
class StorageFactory
{
    // Caching constants
    public const APCU          = 'apcu';
    public const MEMCACHED     = 'memcached';
    public const REDIS         = 'redis';
    public const REDIS_ARRAY   = 'redis-array';
    public const REDIS_CLUSTER = 'redis-cluster';

    /*
     * Default config for Circuit Breaker
     */
    public const DEFAULT_PREFIX = '';
    public const DEFAULT_THRESHOLD = 10;
    public const DEFAULT_DURATION = 500;

    /**
     * Creates storage from static factory method
     *
     * @param string $storage Storage string to create the instance.
     * @param array  $options Storage options to be passed to the instance.
     *
     * @throws \RedisClusterException
     *
     * @return AbstractStorage
     */
    public function create(string $storage, array $options): AbstractStorage
    {
        $options = $this->normaliseOptions($options);

        switch ($storage) {
            case self::APCU:
                return $this->createApcuAdapter($options);
            case self::MEMCACHED:
                return $this->createMemcachedAdapter($options);
            case self::REDIS:
                return $this->createRedisAdapter($options);
            case self::REDIS_ARRAY:
                return $this->createRedisArrayAdapter($options);
            case self::REDIS_CLUSTER:
                return $this->createRedisClusterAdapter($options);
            default:
                throw new \InvalidArgumentException(
                    sprintf('Invalid storage provided: %s', $storage)
                );
        };
    }

    /**
     * Create Memcached Adapter.
     *
     * @param array $options Options to be passed to the memcached adapter.
     *
     * @return Memcached
     */
    protected function createMemcachedAdapter(array $options)
    {
        $memcached = new Memcached(
            $options['prefix'],
            $options['threshold'],
            $options['duration']
        );

        $memcached->create($options);

        return $memcached;
    }

    /**
     * Create Redis Cluster Adapter.
     *
     * @param array $options Options to be passed to the redis cluster adapter.
     *
     * @throws \RedisClusterException
     *
     * @return RedisCluster
     */
    protected function createRedisClusterAdapter(array $options): RedisCluster
    {
        $redis = new RedisCluster(
            $options['prefix'],
            $options['threshold'],
            $options['duration']
        );

        $redis->create($options);

        return $redis;
    }

    /**
     * Create Redis Array Adapter.
     *
     * @param array $options Options to be passed to the redis cluster adapter.
     *
     * @throws \RedisException
     *
     * @return RedisArray
     */
    protected function createRedisArrayAdapter(array $options): RedisArray
    {
        $redis = new RedisArray(
            $options['prefix'],
            $options['threshold'],
            $options['duration']
        );

        $redis->create($options);

        return $redis;
    }

    /**
     * Create Redis Cluster Adapter.
     *
     * @param array $options Options to be passed to the redis cluster adapter.
     *
     * @throws \RedisClusterException
     *
     * @return Redis
     */
    protected function createRedisAdapter(array $options): Redis
    {
        $redis = new Redis(
            $options['prefix'],
            $options['threshold'],
            $options['duration']
        );

        $redis->create($options);

        return $redis;
    }

    /**
     * Build APC instance.
     *
     * @param array $options Options to be passed to the APC adapter.
     *
     * @return Apc
     */
    protected function createApcuAdapter(array $options): Apc
    {
        $apc = new Apc(
            $options['prefix'],
            $options['threshold'],
            $options['duration']
        );

        $apc->create($options);

        return $apc;
    }

    /**
     * Normalise options to return defaults if they aren't set
     *
     * @param array $options Options array to be checked
     *
     * @return array
     */
    protected function normaliseOptions(array $options): array
    {
        if (!isset($options['prefix'])) {
            $options['prefix'] = self::DEFAULT_PREFIX;
        }

        if (!isset($options['duration'])) {
            $options['duration'] = self::DEFAULT_DURATION;
        }

        if (!isset($options['threshold'])) {
            $options['threshold'] = self::DEFAULT_THRESHOLD;
        }

        return $options;
    }
}
