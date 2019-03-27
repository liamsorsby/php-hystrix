<?php

/**
 * Base abstract adapter implementation for php-hystrix.
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

use liamsorsby\Hystrix\Storage\liamsorsby;
use liamsorsby\Hystrix\Storage\StorageInterface;
use Cache\Adapter\Common\AbstractCachePool;

/**
 * Class AbstractStorage
 *
 * @category Adapter
 * @package  Storage
 * @author   Liam Sorsby <liam.sorsby@sky.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache
 * @link     https://github.org/liamsorsby/php-hystrix
 */
abstract class AbstractStorage implements StorageInterface
{
    /**
     * Current storage in use.
     *
     * @var mixed
     */
    protected $storage;

    /**
     * Abstract function for returning the storage instance
     *
     * @param AbstractCachePool $storage Storage name to set the storage too.
     *
     * @return void
     */
    public function setStorage(AbstractCachePool $storage): void
    {
        $this->storage = $storage;
    }

    /**
     * Abstract function for returning the storage instance
     *
     * @return AbstractCachePool
     */
    public function getStorage(): AbstractCachePool
    {
        return $this->storage;
    }

    /**
     * Load the current state of a circuit breaker.
     *
     * @param string $service Service name to use for the circuit breaker.
     *
     * @return bool
     */
    abstract public function load(string $service): bool;

    /**
     * Acquire a lock within the desired adapter.
     *
     * @param string $service Service name to use for the circuit breaker.
     * @param string $value   Value to save into the storage.
     * @param int    $ttl     TTL for the current lock.
     *
     * @return bool|null
     */
    abstract public function lock(string $service, string $value, int $ttl): ?bool;

    /**
     * Unlock the current lock.
     *
     * @param string $service Circuit breaker name.
     *
     * @return bool
     */
    abstract public function unlock(string $service): bool;
}
