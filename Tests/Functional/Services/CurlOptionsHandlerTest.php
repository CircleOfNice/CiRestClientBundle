<?php

namespace Ci\RestClientBundle\Tests\Functional\Services;

use Ci\RestClientBundle\Services\CurlOptionsHandler;

/**
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Ci\RestClientBundle\Services\CurlOptionsHandler
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class CurlOptionsHandlerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var CurlOptionsHandler
     */
    private $curlOptionsHandler;

    /**
     * @var array
     */
    private $defaultOptions = array(CURLOPT_RETURNTRANSFER => true);

    /**
     * {@inheritDoc}
     */
    public function setUp() {
        $this->curlOptionsHandler = new CurlOptionsHandler($this->defaultOptions);
    }

    /**
     * @test
     * @group  small
     * @covers ::__construct
     * @covers ::<private>
     */
    public function construct() {
        $curlOptionsHandler = new CurlOptionsHandler(array());
        unset($curlOptionsHandler);
    }

    /**
     * @test
     * @group  small
     * @covers ::reset
     * @covers ::<private>
     */
    public function reset() {
        $reflectionClass = new \ReflectionClass($this->curlOptionsHandler);
        $property = $reflectionClass->getProperty('options');
        $property->setAccessible(true);
        $property->setValue($this->curlOptionsHandler, array());

        $this->assertInstanceOf(get_class($this->curlOptionsHandler), $this->curlOptionsHandler->reset());

        $this->assertSame($this->defaultOptions, $property->getValue($this->curlOptionsHandler));
    }

    /**
     * @test
     * @group  small
     * @covers ::setOptions
     * @covers ::getOptions
     * @covers ::<private>
     */
    public function setGetOptions() {
        $this->assertInstanceOf(get_class($this->curlOptionsHandler), $this->curlOptionsHandler->setOptions($this->defaultOptions));
        $this->assertSame($this->defaultOptions, $this->curlOptionsHandler->getOptions());
    }

    /**
     * @test
     * @group  small
     * @covers ::setOption
     * @covers ::<private>
     */
    public function setOption() {
        $this->assertInstanceOf(get_class($this->curlOptionsHandler), $this->curlOptionsHandler->setOption(CURLOPT_RETURNTRANSFER, false));

        $reflectionClass = new \ReflectionClass($this->curlOptionsHandler);
        $property = $reflectionClass->getProperty('options');
        $property->setAccessible(true);
        $this->assertSame(array(CURLOPT_RETURNTRANSFER => false), $property->getValue($this->curlOptionsHandler));
    }

    /**
     * @test
     * @group  small
     * @covers ::setOption
     * @covers ::<private>
     *
     * @expectedException \InvalidArgumentException
     */
    public function setOptionOnError() {
        $this->assertInstanceOf(get_class($this->curlOptionsHandler), $this->curlOptionsHandler->setOption('CURLOPT_RETURNTRANSFER', false));
    }

}