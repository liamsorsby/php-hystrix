<?php

namespace spec\liamsorsby\Hystrix\Storage\Adapter;

use Cache\Adapter\Memcached\MemcachedCachePool;
use liamsorsby\Hystrix\Storage\Adapter\AbstractStorage;
use PhpSpec\ObjectBehavior;
use liamsorsby\Hystrix\Storage\Adapter\Memcached;

class MemcachedSpec extends ObjectBehavior
{
    function let(MemcachedCachePool $pool)
    {
        $this->beConstructedWith('test', 1, 1);
        $this->setStorage($pool);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Memcached::class);
    }

    function it_implements_abstract_storage()
    {
        $this->shouldHaveType(AbstractStorage::class);
    }

    function it_should_set_open_when_reporting_failure_above_threshold(MemcachedCachePool $pool)
    {
        $pool->get('testfailcountservice')->shouldBeCalledOnce();
        $pool->set('testfailcountservice', 1, 1)->shouldBeCalledOnce();
        $pool->set('testopenservice', 1, 1)->shouldBeCalledOnce();

        $this->reportFailure('service', 'value');
    }

    function it_should_create_an_instance_of_memcached(MemcachedCachePool $pool, \Memcached $memcached)
    {
        $options = [
            'servers' => [
                [
                    'mem1.domain.com',
                    11211,
                    33
                ]
            ]
        ];

        $pool->beConstructedWith([$memcached]);

        $this->create($options);
    }
}
