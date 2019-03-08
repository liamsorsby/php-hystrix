<?php

/**
 * RedisCluster implementation for php-hystrix.
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

namespace liamsorsby\Hystrix\Storage\Adapter;

use Cache\Adapter\Apcu\ApcuCachePool;
use \Psr\SimpleCache\InvalidArgumentException;

/**
 * Class Apc
 *
 * @category Adapter
 * @package  Storage
 * @author   Liam Sorsby <liam.sorsby@sky.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache
 * @link     https://github.org/liamsorsby/php-hystrix
 */
class Apc extends AbstractStorage
{
    /**
     * Assigns the redis object to the storage.
     *
     * @param ApcuCachePool $apcu Apcu wrapper instance.
     *
     * @return void
     */
    public function __construct(ApcuCachePool $apcu)
    {
        $this->storage = $apcu;
    }

    /**
     * Get storage object.
     *
     * @return ApcuCachePool
     */
    public function getStorage(): ApcuCachePool
    {
        return $this->storage;
    }

    /**
     * Acquire an APC lock.
     *
     * @param string $service
     * @param string $value
     * @param int $ttl
     *
     * @return bool
     */
    public function lock(string $service, string $value, int $ttl): bool
    {
        try {
            return (bool) $this->getStorage()->set($service, $value, $ttl);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Remove APC lock.
     *
     * @param string $service
     *
     * @return bool
     */
    public function unlock(string $service): bool
    {
        try {
            return (bool) $this->getStorage()->delete($service);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Load APC to check if a lock is enabled or not.
     *
     * @param string $service
     *
     * @return bool
     */
    public function load(string $service): bool
    {
        try {
            return null !== $this->getStorage()->get($service);
        } catch (\Exception $exception) {
            return false;
        }
    }
}
