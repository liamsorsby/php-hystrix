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

use Cache\Adapter\Redis\RedisCachePool;

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
     * {@inheritDoc}
     *
     * @param array $options Options required to create the storage instance
     *
     * @throws \RedisClusterException
     *
     * @return void
     */
    public function create(array $options): void
    {
        $redis = new \RedisCluster(
            $options['name'],
            $options['seeds'],
            $options['timeout'] ?? null,
            $options['readTimeout'] ?? null,
            $options['persistent'] ?? false
        );

        $this->setStorage(new RedisCachePool($redis));
    }
}
