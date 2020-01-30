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
        $this->beConstructedWith('test', 2, 1);
        $this->setStorage($apcu);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractStorage::class);
    }

    function it_should_return_an_apc_instance()
    {
        $this->getStorage()->shouldBeAnInstanceOf(AbstractCachePool::class);
    }

    function it_should_return_true_when_reporting_failure(ApcuCachePool $apcu)
    {
        $apcu->get('testfailcountservice')->shouldBeCalledOnce();
        $apcu->set('testfailcountservice', 1, 1)->shouldBeCalledOnce();

        $this->reportFailure('service', 'value');
    }

    function it_should_have_a_create_function_that_returns_APC_instance(ApcuCachePool $apcu)
    {
        $apcu->beConstructedWith([false]);
        $this->create([]);
    }
}
