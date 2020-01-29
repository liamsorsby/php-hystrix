<?php

namespace tests\Unit\liamsorsby\Hystrix\Storage\Adapter;

use _HumbugBox1e3709914867\Nette\Neon\Exception;
use liamsorsby\Hystrix\Storage\Adapter\Apc;
use PHPUnit\Framework\TestCase;
use Cache\Adapter\Apcu\ApcuCachePool;

final class AbstractStorageTest extends TestCase
{

    /**
     * @var ApcuCachePool
     */
    private $apcu;

    private $prefix = "test";
    private $service = "apc";
    private $duration = 20;
    private $threshold = 10;

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
        $underTest = new Apc($this->prefix, $this->threshold, $this->duration);
        $underTest->setStorage($this->apcu);
        $this->assertTrue($underTest->getStorage() instanceof ApcuCachePool);
    }

    public function testCallToIsAvailableReturnsTrueWithNoLock()
    {
        $underTest = new Apc($this->prefix, $this->threshold, $this->duration);
        $underTest->setStorage($this->apcu);
        $this->assertFalse($underTest->isOpen($this->service));
    }

    public function testCallToIsAvailableWhenKeyExistsReturnsFalse()
    {
        $this->apcu
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue(true));

        $underTest = new Apc($this->prefix, $this->threshold, $this->duration);
        $underTest->setStorage($this->apcu);
        $this->assertTrue($underTest->isOpen($this->service));
    }

    public function testCallToStorageIsOneIfItDoesNotExist()
    {
        $this->apcu
            ->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnValue(false));

        $this->apcu
            ->expects($this->once())
            ->method('set');

        $underTest = new Apc($this->prefix, $this->threshold, $this->duration);
        $underTest->setStorage($this->apcu);
        $underTest->reportFailure($this->service, "test");
        $this->assertFalse($underTest->isOpen($this->service));
    }

    public function testCallToStorageIstwoIfItDoesExist()
    {
        $this->apcu
            ->expects($this->exactly(1))
            ->method('get')
            ->will($this->returnValue(1));

        $this->apcu
            ->expects($this->once())
            ->method('set');

        $underTest = new Apc($this->prefix, $this->threshold, $this->duration);
        $underTest->setStorage($this->apcu);
        $underTest->reportFailure($this->service, "test");
    }

    public function testCallToIsOpenReturnsFalseIfExceptionIsThrown()
    {
        $this->apcu
            ->expects($this->once())
            ->method('get')
            ->will($this->throwException(new Exception("test")));
        $underTest = new Apc($this->prefix, 0, $this->duration);
        $underTest->setStorage($this->apcu);
        $this->assertFalse($underTest->isOpen($this->service));
    }

    public function testCallToStorageWithFailureGreaterThanThresholdReturnsIsOpen()
    {
        $this->apcu
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue(0));

        $this->apcu
            ->expects($this->exactly(2))
            ->method('set');

        $underTest = new Apc($this->prefix, 0, $this->duration);
        $underTest->setStorage($this->apcu);
        $underTest->reportFailure($this->service, "test");
    }
}