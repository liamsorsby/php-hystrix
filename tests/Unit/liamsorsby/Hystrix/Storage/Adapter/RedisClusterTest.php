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
        $underTest = new RedisCluster($this->redis);
        $this->assertTrue($underTest->getStorage() instanceof \RedisCluster);
    }

    public function testRedisLockWillReturnTrue() :void
    {
        $this->redis->expects($this->once())
            ->method('set')
            ->willReturn(true);

        $underTest = new RedisCluster($this->redis);
        $this->assertTrue($underTest->lock('test', 'test', 1234));
    }

    public function testRedisLockWillThrowAnErrorIfStorageDoesNotExist() :void
    {
        $this->expectException(\TypeError::class);
        $underTest = new RedisCluster();
        $underTest->lock('test', 'test', 1234);
    }

    public function testRedisUnlockWillReturnTrue() :void
    {
        $this->redis->expects($this->once())
            ->method('del')
            ->willReturn(1);

        $underTest = new RedisCluster($this->redis);
        $this->assertTrue($underTest->unlock('foo'));
    }

    public function testRedisUnlockWillThrowAnErrorIfStorageDoesNotExist() :void
    {
        $this->expectException(\TypeError::class);
        $underTest = new RedisCluster();
        $this->assertTrue($underTest->unlock('foo'));
    }

    /**
     * @dataProvider redisGetProvider
     */
    public function testRedisLoadReturnsCorrectBool($value, $expected)
    {
        $this->redis->expects($this->once())
            ->method('get')
            ->willReturn($value);

        $underTest = new RedisCluster($this->redis);

        $this->assertEquals($expected, $underTest->load('foo-bar'));
    }

    public function redisGetProvider(): array
    {
        return [
            ['', true],
            ['asd', true],
            [false, false],
            [true, false],
            [null, false],
        ];
    }

    public function testRedisLoadThrowsExceptionIfStorageIsUnset()
    {
        $this->expectException(\TypeError::class);
        $underTest = new RedisCluster();

        $underTest->load('foo-bar');
    }
}
