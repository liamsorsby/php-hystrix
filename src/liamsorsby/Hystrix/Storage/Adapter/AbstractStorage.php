<?php

namespace liamsorsby\Hystrix\Storage\Adapter;

use liamsorsby\Hystrix\Storage\liamsorsby;
use liamsorsby\Hystrix\Storage\StorageInterface;

abstract class AbstractStorage implements StorageInterface
{
    /**
     * @var mixed
     */
    protected $storage;

    /**
     * Abstract function for returning the storage instance
     *
     * @return mixed
     */
    abstract public function getStorage();

    /**
     * {@inheritdoc}
     */
    abstract public function load(string $service);

    /**
     * {@inheritdoc}
     */
    abstract public function save(string $service, string $value);

    /**
     * {@inheritdoc}
     */
    abstract public function lock(string $service, string $value, int $ttl): ?bool;

    /**
     * {@inheritdoc}
     */
    abstract public function unlock(string $service, string $value): ?bool;
}
