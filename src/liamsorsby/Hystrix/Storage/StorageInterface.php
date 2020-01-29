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
     * Reports a failure scenario to storage handler
     *
     * @param string $service The name of service.
     *
     * @throws \liamsorsby\Hystrix\Storage\StorageException
     *
     * @return void
     */
    public function reportFailure(string $service): void;

    /**
     * Reports if circuit breaker is open or not
     *
     * @param string $service String to determine which service we are checking
     *
     * @return bool
     */
    public function isOpen(string $service): bool;
}
