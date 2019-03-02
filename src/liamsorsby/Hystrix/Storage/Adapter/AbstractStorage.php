<?php

namespace liamsorsby\Hystrix\Storage\Adapter;

use liamsorsby\Hystrix\Storage\liamsorsby;
use liamsorsby\Hystrix\Storage\StorageInterface;

abstract class AbstractStorage implements StorageInterface
{
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
