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

/**
 * Class RedisCluster
 *
 * @category Adapter
 * @package  Storage
 * @author   Liam Sorsby <liam.sorsby@sky.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache
 * @link     https://github.org/liamsorsby/php-hystrix
 */
class RedisCluster extends AbstractStorage
{
    /**
     * Load redis to check if redis lock is enabled or not.
     *
     * @param string $service Service name used for the circuit breaker.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function load(string $service): bool
    {
        $result = $this->getStorage()->get($service);
        if (null === $result || is_string($result)) {
            return false;
        }

        return $result;
    }

    /**
     * Acquire a redis lock.
     *
     * @param string $service Service name for the circuit breaker.
     * @param string $value   Value to save into the redis circuit breaker.
     * @param int    $ttl     TTL of the redis lock.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool|null
     */
    public function lock(string $service, string $value, int $ttl): ?bool
    {
        return $this->getStorage()->set($service, $value, ['NX', 'PX' => $ttl]);
    }

    /**
     * Remove the current lock.
     *
     * @param string $service Service name of the circuit breaker to remove.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function unlock(string $service): bool
    {
        return $this->getStorage()->delete($service) ?? false;
    }
}
