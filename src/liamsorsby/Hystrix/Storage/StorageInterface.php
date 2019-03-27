<?php

/**
 * Storage Interface.
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

/**
 * This is a basic interface to describe the minimum contract
 * between storage's.
 *
 * @category Adapter
 * @package  Storage
 * @author   Liam Sorsby <liam.sorsby@sky.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache
 * @link     https://github.org/liamsorsby/php-hystrix
 */
interface StorageInterface
{

    /**
     * Loads the hystrix status from storage.
     *
     * @param string $service The name of the service to load.
     *
     * @throws \liamsorsby\Hystrix\Storage\StorageException
     *
     * @return bool  value stored value was not found
     */
    public function load(string $service);

    /**
     * Creates a circuit breaker.
     *
     * @param string $service The name of service.
     * @param string $value   The value of the circuit breaker.
     * @param int    $ttl     The ttl of the circuit breaker.
     *
     * @throws \liamsorsby\Hystrix\Storage\StorageException
     *
     * @return bool
     */
    public function lock(string $service, string $value, int $ttl): ?bool;

    /**
     * Creates a circuit breaker.
     *
     * @param string $service The name of service.
     *
     * @throws \liamsorsby\Hystrix\Storage\StorageException
     *
     * @return boolean
     */
    public function unlock(string $service): bool;
}
