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

use Cache\Adapter\Apcu\ApcuCachePool;
use Cache\Adapter\Redis\RedisCachePool;
use liamsorsby\Hystrix\Storage\Adapter\{AbstractStorage, Apc, RedisCluster};

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
    public const REDISCLUSTER = 'redis-cluster';
    public const APCU = 'apcu';
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
        case self::REDISCLUSTER:
            return $this->createRedisClusterAdapter($options);
        case self::APCU:
            return $this->createApcuAdapter($options);
        default:
            throw new \InvalidArgumentException(
                sprintf('Invalid storage provided: %s', $storage)
            );
        };
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
        $storage = new RedisCluster(
            $options['prefix'],
            $options['threshold'],
            $options['duration']
        );

        $storage->setStorage(
            $this->createRedisCluster($options)
        );

        return $storage;
    }

    /**
     * Build Redis Cluster Config
     *
     * @param array $options Options to be passed to the redis cluster.
     *
     * @throws \RedisClusterException
     *
     * @return RedisCachePool
     */
    protected function createRedisCluster(array $options): RedisCachePool
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
        $apc->setStorage(new ApcuCachePool($options['skipOnCli'] ?? false));

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
