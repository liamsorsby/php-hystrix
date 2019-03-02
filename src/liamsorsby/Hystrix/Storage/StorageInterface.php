<?php

/**
 * Storage Interface.
 *
 * @link https://github.org/liamsorsby/php-hystrix
 * @author Liam Sorsby
 *
 * For the full copyright and license information, please view the LICENSE file.
 */

namespace liamsorsby\Hystrix\Storage;

/**
 * This is a basic interface to describe the minimum contract
 * between storage's.
 */
interface StorageInterface {

    /**
     * Loads the hystrix status from storage.
     *
     * @param string  $service  The name of the service to load.
     *
     * @throws \liamsorsby\Hystrix\Storage\StorageException
     *
     * @return 	string  value stored or '' if value was not found
     */
    public function load(string $service);

    /**
     * Creates a circuit breaker.
     *
     * @param   string  $service    The name of service.
     * @param   string  $value      The value of the circuit breaker.
     * @param   int     $ttl        The ttl of the circuit breaker.
     *
     * @throws \liamsorsby\Hystrix\Storage\StorageException
     *
     * @return 	bool
     */
    public function lock(string $service, string $value, int $ttl): ?bool;

    /**
     * Creates a circuit breaker.
     *
     * @param   string  $service    The name of service.
     *
     * @throws \liamsorsby\Hystrix\Storage\StorageException
     *
     * @return 	boolean
     */
    public function unlock(string $service): bool;
}
