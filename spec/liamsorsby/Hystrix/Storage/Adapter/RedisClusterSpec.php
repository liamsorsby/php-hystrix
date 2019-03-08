<?php

namespace spec\liamsorsby\Hystrix\Storage\Adapter;

use liamsorsby\Hystrix\Storage\Adapter\AbstractStorage;
use PhpSpec\ObjectBehavior;

class RedisClusterSpec extends ObjectBehavior
{

    function let(\RedisCluster $redisCluster)
    {
        $this->beConstructedWith($redisCluster);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractStorage::class);
    }

    function it_should_return_a_redis_cluster_instance()
    {
        $this->getStorage()->shouldBeAnInstanceOf(\RedisCluster::class);
    }

    function it_should_return_true_when_locking(\RedisCluster $redisCluster)
    {
        $this->beConstructedWith($redisCluster);
        $redisCluster->set('service', 'value', ['NX', 'PX' => 1000])->shouldBeCalledOnce();

        $this->lock('service', 'value', 1000);
    }

    function it_should_return_true_when_unlocking(\RedisCluster $redisCluster)
    {
        $this->beConstructedWith($redisCluster);
        $redisCluster->del('service')->shouldBeCalledOnce();

        $this->unlock('service');
    }

    function it_should_return_true_when_dataset_has_lock_load(\RedisCluster $redisCluster)
    {
        $this->beConstructedWith($redisCluster);
        $redisCluster->get('service')->shouldBeCalledOnce();

        $this->load('service');
    }
}
