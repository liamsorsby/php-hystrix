<?php

namespace tests\Unit\liamsorsby\Hystrix\Storage\Adapter;

use liamsorsby\Hystrix\Storage\Adapter\RedisCluster;
use PHPUnit\Framework\TestCase;

final class RedisClusterTest extends TestCase
{
    public function testGetStorageReturnsAnInstanceOfRedisCluster()
    {
        $redis = $this->getMockBuilder(\RedisCluster::class)
            ->disableOriginalConstructor()
            ->getMock();

        $underTest = new RedisCluster([]);
        $underTest->createConnection($redis);
        $this->assertTrue($underTest->getStorage() instanceof \RedisCluster);
    }
}
