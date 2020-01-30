<?php

namespace tests\Unit\liamsorsby\Hystrix\Storage;

use liamsorsby\Hystrix\Storage\Adapter\Apc;
use liamsorsby\Hystrix\Storage\Adapter\Memcached;
use liamsorsby\Hystrix\Storage\Adapter\Redis;
use liamsorsby\Hystrix\Storage\Adapter\RedisArray;
use liamsorsby\Hystrix\Storage\Adapter\RedisCluster;
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

        $factory->create(StorageFactory::APCU, []);
    }

    public function testRedisClusterStorageIsReturnedWhenKeyIsUsed()
    {
        $factory = $this->getMockBuilder(StorageFactory::class)
            ->setMethods(['createRedisClusterAdapter'])
            ->disableOriginalConstructor()
            ->getMock();

        $redis = $this->getMockBuilder(RedisCluster::class)
            ->disableOriginalConstructor()
            ->getMock();


        $factory->expects($this->once())
            ->method('createRedisClusterAdapter')
            ->will($this->returnValue($redis));

        $factory->create(StorageFactory::REDIS_CLUSTER, ["name" => "test", "seeds" => ['test']]);
    }

    public function testRedisArrayStorageIsReturnedWhenKeyIsUsed()
    {
        $factory = $this->getMockBuilder(StorageFactory::class)
            ->setMethods(['createRedisArrayAdapter'])
            ->disableOriginalConstructor()
            ->getMock();

        $redis = $this->getMockBuilder(RedisArray::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory->expects($this->once())
            ->method('createRedisArrayAdapter')
            ->will($this->returnValue($redis));

        $factory->create(StorageFactory::REDIS_ARRAY, ["host" => "test"]);
    }

    public function testRedisStorageIsReturnedWhenKeyIsUsed()
    {
        $factory = $this->getMockBuilder(StorageFactory::class)
            ->setMethods(['createRedisAdapter'])
            ->disableOriginalConstructor()
            ->getMock();

        $redis = $this->getMockBuilder(Redis::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory->expects($this->once())
            ->method('createRedisAdapter')
            ->will($this->returnValue($redis));

        $factory->create(StorageFactory::REDIS, ["name" => "test", "host" => 'test']);
    }

    public function testMemcachedStorageIsReturnedWhenKeyIsUsed()
    {
        $factory = $this->getMockBuilder(StorageFactory::class)
            ->setMethods(['createMemcachedAdapter'])
            ->disableOriginalConstructor()
            ->getMock();

        $memcached = $this->getMockBuilder(Memcached::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory->expects($this->once())
            ->method('createMemcachedAdapter')
            ->will($this->returnValue($memcached));

        $options = [
            'servers' => [
                [
                    'mem1.domain.com',
                    11211,
                    33
                ]
            ]
        ];

        $factory->create(StorageFactory::MEMCACHED, $options);
    }
}
