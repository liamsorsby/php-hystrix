<?php

namespace spec\liamsorsby\Hystrix\Storage\Adapter;

use liamsorsby\Hystrix\Storage\Adapter\AbstractStorage;
use liamsorsby\Hystrix\Storage\StorageInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AbstractStorageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractStorage::class);
    }

    function it_should_implement_storage_interface()
    {
        $this->shouldBeAnInstanceOf(StorageInterface::class);
    }
}
