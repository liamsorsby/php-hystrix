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

use liamsorsby\Hystrix\Storage\StorageInterface;
use Cache\Adapter\Common\AbstractCachePool;
use Psr\SimpleCache\InvalidArgumentException;

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
     * Failure Prefix
     *
     * @var string
     */
    protected $failurePrefix;

    /**
     * Open Prefix
     *
     * @var string
     */
    protected $openPrefix;

    /**
     * Circuit Breaker Threshold
     *
     * @var int
     */
    protected $threshold;

    /**
     * Circuit Breaker Duration
     *
     * @var int
     */
    protected $duration;

    /**
     * AbstractStorage constructor.
     *
     * @param string $prefix    String to prefix fail count to prevent collision
     * @param int    $threshold Max number of failures in given time
     * @param int    $duration  Duration for threshold to be appended to
     */
    public function __construct(string $prefix, int $threshold, int $duration)
    {
        $this->failurePrefix = $prefix . 'failcount';
        $this->openPrefix = $prefix . 'open';
        $this->duration = $duration;
        $this->threshold = $threshold;
    }

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
     * Report a failed state to storage
     *
     * @param string $service Name of the lock
     * @param string $value   String to set the lock too
     *
     * @return void
     */
    public function reportFailure(string $service, string $value): void
    {
        $currentCount = $this->getStorage()->get(
            $this->failurePrefix . $service
        );

        $newTotal = ((int)$currentCount)+1;

        if (!(bool) $currentCount) {
            $this->getStorage()->set(
                $this->failurePrefix . $service,
                1,
                $this->duration
            );
        } else {
            $this->getStorage()->set(
                $this->failurePrefix . $service,
                $newTotal
            );
        }

        if ($newTotal >= $this->threshold) {
            $this->getStorage()->set(
                $this->openPrefix . $service,
                1,
                $this->duration
            );
        }
    }


    /**
     * Check if circuit breaker is open
     *
     * @param string $service Name of service being checked
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function isOpen(string $service): bool
    {
        try {
            return (bool) $this->getStorage()->get(
                $this->openPrefix.$service,
                false
            );
        } catch (\Exception $e) {
            return false;
        }
    }
}
