<?php

namespace spec\liamsorsby\Hystrix\Storage\Adapter;

use Cache\Adapter\Redis\RedisCachePool;
use liamsorsby\Hystrix\Storage\Adapter\AbstractStorage;
use PhpSpec\ObjectBehavior;

class RedisClusterSpec extends ObjectBehavior
{

    function let(RedisCachePool $redisCluster)
    {
        $this->setStorage($redisCluster);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractStorage::class);
    }

    function it_should_return_a_redis_cluster_instance()
    {
        $this->getStorage()->shouldBeAnInstanceOf(RedisCachePool::class);
    }

    function it_should_return_true_when_locking(RedisCachePool $redisCluster)
    {
        $this->setStorage($redisCluster);
        $redisCluster->set('service', 'value', ['NX', 'PX' => 1000])->shouldBeCalledOnce();

        $this->lock('service', 'value', 1000);
    }

    function it_should_return_true_when_unlocking(RedisCachePool $redisCluster)
    {
        $this->setStorage($redisCluster);
        $redisCluster->delete('service')->shouldBeCalledOnce();

        $this->unlock('service');
    }

    function it_should_return_true_when_dataset_has_lock_load(RedisCachePool $redisCluster)
    {
        $this->setStorage($redisCluster);
        $redisCluster->get('service')->shouldBeCalledOnce();

        $this->load('service');
    }
}
