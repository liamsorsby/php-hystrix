<?php

namespace tests\Unit\liamsorsby\Hystrix\Storage\Adapter;

use liamsorsby\Hystrix\Storage\Adapter\RedisCluster;
use PHPUnit\Framework\TestCase;

final class RedisClusterTest extends TestCase
{
    /**
     * @var \RedisCluster
     */
    private $redis;

    public function setUp(): void
    {
        parent::setUp();

        $this->redis = $this->getMockBuilder(\RedisCluster::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->redis = null;
    }

    public function testGetStorageReturnsAnInstanceOfRedisCluster() :void
    {
        $underTest = new RedisCluster();
        $underTest->createConnection($this->redis);
        $this->assertTrue($underTest->getStorage() instanceof \RedisCluster);
    }

    public function testRedisLockWillReturnTrue() :void
    {
        $this->redis->expects($this->once())
            ->method('set')
            ->willReturn(true);

        $underTest = new RedisCluster();
        $underTest->createConnection($this->redis);
        $this->assertTrue($underTest->lock('test', 'test', 1234));
    }
}
