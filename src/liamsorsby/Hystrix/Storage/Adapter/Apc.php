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
     * {@inheritDoc}
     *
     * @param array $options Options required to create the storage instance
     *
     * @return void
     */
    public function create(array $options): void
    {
        $apc = new ApcuCachePool($options['skipOnCli'] ?? false);
        $this->setStorage($apc);
    }
}
