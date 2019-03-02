<?php

namespace spec\liamsorsby\Hystrix\Storage\Adapter;

use liamsorsby\Hystrix\Storage\Adapter\AbstractStorage;
use PhpSpec\ObjectBehavior;

class RedisClusterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            "foo" => "bar"
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractStorage::class);
    }

    function it_should_set_a_redis_instance_create_connection(\RedisCluster $redisCluster)
    {
        $this->createConnection($redisCluster)->shouldBeNull();
    }

    function it_should_return_a_redis_cluster_instance(\RedisCluster $redisCluster)
    {
        $this->createConnection($redisCluster)->shouldBeNull();
        $this->getStorage()->shouldBeAnInstanceOf(\RedisCluster::class);
    }
}
