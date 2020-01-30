<?php

namespace spec\liamsorsby\Hystrix\Storage\Adapter;

use Cache\Adapter\Redis\RedisCachePool;
use liamsorsby\Hystrix\Storage\Adapter\RedisCluster;
use PhpSpec\ObjectBehavior;

class RedisClusterSpec extends ObjectBehavior
{

    function let(RedisCachePool $redisCluster)
    {
        $this->beConstructedWith('test', 1, 1);
        $this->setStorage($redisCluster);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RedisCluster::class);
    }

    function it_should_return_a_redis_cluster_instance()
    {
        $this->getStorage()->shouldBeAnInstanceOf(RedisCachePool::class);
    }


    function it_should_set_open_when_reporting_failure_above_threshold(RedisCachePool $redisCluster)
    {
        $redisCluster->get('testfailcountservice')->shouldBeCalledOnce();
        $redisCluster->set('testfailcountservice', 1, 1)->shouldBeCalledOnce();
        $redisCluster->set('testopenservice', 1, 1)->shouldBeCalledOnce();

        $this->reportFailure('service', 'value');
    }
}
