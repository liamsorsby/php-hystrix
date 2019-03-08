<?php

namespace spec\liamsorsby\Hystrix\Storage\Adapter;

use Cache\Adapter\Apcu\ApcuCachePool;
use Cache\Adapter\Common\AbstractCachePool;
use liamsorsby\Hystrix\Storage\Adapter\AbstractStorage;
use PhpSpec\ObjectBehavior;

class ApcSpec extends ObjectBehavior
{

    function let(ApcuCachePool $apcu)
    {
        $this->beConstructedWith($apcu);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractStorage::class);
    }

    function it_should_return_an_apc_instance()
    {
        $this->getStorage()->shouldBeAnInstanceOf(AbstractCachePool::class);
    }

    function it_should_return_true_when_locking(ApcuCachePool $apcu)
    {
        $this->beConstructedWith($apcu);
        $apcu->set('service', 'value', 1000)->shouldBeCalledOnce();

        $this->lock('service', 'value', 1000);
    }

    function it_should_return_true_when_unlocking(ApcuCachePool $apcu)
    {
        $this->beConstructedWith($apcu);
        $apcu->delete('service')->shouldBeCalledOnce();
        $this->unlock('service');
    }

    function it_should_return_true_when_dataset_has_lock_load(ApcuCachePool $apcu)
    {
        $this->beConstructedWith($apcu);
        $apcu->get('service')->shouldBeCalledOnce();
        $this->load('service');
    }
}
