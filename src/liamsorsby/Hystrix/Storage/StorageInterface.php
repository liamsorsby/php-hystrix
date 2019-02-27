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
     * @throws liamsorsby\Hystrix\Storage\StorageException
     *
     * @return 	string  value stored or '' if value was not found
     */
    public function load($service);

    /**
     * Saves the circuit breaker status.
     *
     * @param   string  $service    The name of service.
     * @param   string  $value      The value of the circuit breaker.
     *
     * @throws liamsorsby\Hystrix\Storage\StorageException
     *
     * @return 	void
     */
    public function save($service, $value);
}
