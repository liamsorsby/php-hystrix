<?php

namespace tests\Unit\liamsorsby\Hystrix\Storage\Adapter;

use liamsorsby\Hystrix\Storage\Adapter\Apc;
use PHPUnit\Framework\TestCase;
use Cache\Adapter\Apcu\ApcuCachePool;

final class ApcTest extends TestCase
{

    /**
     * @var ApcuCachePool
     */
    private $apcu;

    public function setUp(): void
    {
        parent::setUp();

        $this->apcu = $this->getMockBuilder(ApcuCachePool::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->apcu = null;
    }

    public function testGetStorageReturnsAnInstanceOfRedisCluster() :void
    {
        $underTest = new Apc();
        $underTest->setStorage($this->apcu);
        $this->assertTrue($underTest->getStorage() instanceof ApcuCachePool);
    }

    public function testApcLockWillReturnTrue() :void
    {
        $this->apcu->expects($this->once())
            ->method('set')
            ->willReturn(true);

        $underTest = new Apc();
        $underTest->setStorage($this->apcu);
        $this->assertTrue($underTest->lock('test', 'test', 1234));
    }

    public function testApcLockExceptionWillReturnFalse() :void
    {
        $this->apcu->expects($this->once())
            ->method('set')
            ->will($this->throwException(new \Exception()));

        $underTest = new Apc();
        $underTest->setStorage($this->apcu);
        $this->assertFalse($underTest->lock('test', 'test', 1234));
    }

    public function testApcUnlockWillReturnTrue() :void
    {
        $this->apcu->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $underTest = new Apc();
        $underTest->setStorage($this->apcu);
        $this->assertTrue($underTest->unlock('test'));
    }

    public function testApcUnlockErrorWillReturnFalse() :void
    {
        $this->apcu->expects($this->once())
            ->method('delete')
            ->will($this->throwException(new \Exception()));

        $underTest = new Apc();
        $underTest->setStorage($this->apcu);
        $this->assertFalse($underTest->unlock('test'));
    }

    public function testApcLoadWillReturnTrue() :void
    {
        $this->apcu->expects($this->once())
            ->method('get')
            ->willReturn(true);

        $underTest = new Apc();
        $underTest->setStorage($this->apcu);
        $this->assertTrue($underTest->load('test'));
    }

    public function testApcLoadErrorWillReturnFalse() :void
    {
        $this->apcu->expects($this->once())
            ->method('get')
            ->will($this->throwException(new \Exception()));

        $underTest = new Apc();
        $underTest->setStorage($this->apcu);
        $this->assertFalse($underTest->load('test'));
    }

}