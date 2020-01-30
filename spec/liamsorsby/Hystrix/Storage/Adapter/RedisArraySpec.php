<?php

namespace spec\liamsorsby\Hystrix\Storage\Adapter;

use Cache\Adapter\Redis\RedisCachePool;
use liamsorsby\Hystrix\Storage\Adapter\RedisArray;
use PhpSpec\ObjectBehavior;

class RedisArraySpec extends ObjectBehavior
{

    function let(RedisCachePool $redis)
    {
        $this->beConstructedWith('test', 1, 1);
        $this->setStorage($redis);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RedisArray::class);
    }

    function it_should_return_a_redis_cluster_instance()
    {
        $this->getStorage()->shouldBeAnInstanceOf(RedisCachePool::class);
    }

    function it_should_set_open_when_reporting_failure_above_threshold(RedisCachePool $redis)
    {
        $redis->get('testfailcountservice')->shouldBeCalledOnce();
        $redis->set('testfailcountservice', 1, 1)->shouldBeCalledOnce();
        $redis->set('testopenservice', 1, 1)->shouldBeCalledOnce();

        $this->reportFailure('service', 'value');
    }

    function it_should_create_an_instance_of_redis(RedisCachePool $redisCachePool)
    {
        $options = [
            'host' => 'seeds',
            'port' => 6379,

        ];
        $this->create($options);
    }
}
