<?php

/**
 * Redis implementation for php-hystrix.
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

use Cache\Adapter\Redis\RedisCachePool;

/**
 * Class Redis
 *
 * @category Adapter
 * @package  Storage
 * @author   Liam Sorsby <liam.sorsby@sky.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache
 * @link     https://github.org/liamsorsby/php-hystrix
 */
class Redis extends AbstractStorage
{
    /**
     * {@inheritDoc}
     *
     * @param array $options Options required to create the storage instance
     *
     * @return void
     */
    public function create(array $options): void
    {
        $redis = new \Redis();
        $redis->connect(
            $options['host'],
            $options['port'] ?? 6379,
            $options['timeout'] ?? 0.00,
            $options['reserved'] ?? null,
            $options['retryInterval'] ?? 0,
            $options['readTimeout'] ?? 0.00
        );
        $this->setStorage(new RedisCachePool($redis));
    }
}
