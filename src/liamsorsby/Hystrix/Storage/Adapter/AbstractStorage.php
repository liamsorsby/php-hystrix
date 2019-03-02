<?php

namespace liamsorsby\Hystrix\Storage\Adapter;

use liamsorsby\Hystrix\Storage\liamsorsby;
use liamsorsby\Hystrix\Storage\StorageInterface;

abstract class AbstractStorage implements StorageInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var mixed
     */
    protected $storage;

    /**
     * AbstractStorage constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Abstract function for returning the storage instance
     *
     * @return mixed
     */
    abstract public function getStorage();

    /**
     * {@inheritdoc}
     */
    public function load($service)
    {
        // TODO: Implement load() method.
    }

    /**
     * {@inheritdoc}
     */
    public function save($service, $value)
    {
        // TODO: Implement save() method.
    }
}
