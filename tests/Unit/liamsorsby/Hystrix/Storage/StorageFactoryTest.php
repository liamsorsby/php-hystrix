<?php

namespace tests\Unit\liamsorsby\Hystrix\Storage;

use Cache\Adapter\Redis\RedisCachePool;
use liamsorsby\Hystrix\Storage\Adapter\AbstractStorage;
use liamsorsby\Hystrix\Storage\Adapter\Apc;
use liamsorsby\Hystrix\Storage\StorageFactory;
use PHPUnit\Framework\TestCase;

class StorageFactoryTest extends TestCase
{
    public function testInvalidStorageThrowsExceptions()
    {
        $this->expectException(\InvalidArgumentException::class);

        $factory = new StorageFactory();
        $factory->create('this-is-a-test', []);
    }

    public function testApcStorageIsReturnedWhenKeyIsUsed()
    {
        $factory = $this->getMockBuilder(StorageFactory::class)
            ->setMethods(['createApcuAdapter'])
            ->disableOriginalConstructor()
            ->getMock();

        $apc = $this->getMockBuilder(Apc::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory->expects($this->once())
            ->method('createApcuAdapter')
            ->will($this->returnValue($apc));

        $storage = $factory->create(StorageFactory::APCU, []);

        $this->assertTrue($storage instanceof AbstractStorage);
    }

    public function testRedisClusterStorageIsReturnedWhenKeyIsUsed()
    {
        $factory = $this->getMockBuilder(StorageFactory::class)
            ->setMethods(['createRedisCluster'])
            ->disableOriginalConstructor()
            ->getMock();

        $redis = $this->getMockBuilder(RedisCachePool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory->expects($this->once())
            ->method('createRedisCluster')
            ->will($this->returnValue($redis));

        $storage = $factory->create(StorageFactory::REDISCLUSTER, []);

        $this->assertTrue($storage instanceof AbstractStorage);
    }
}