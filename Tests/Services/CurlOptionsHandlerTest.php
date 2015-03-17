<?php

namespace Ci\CurlBundle\Tests\Services;

require_once __DIR__ . '/../../../../../app/AppKernel.php';

use Ci\CurlBundle\Services\CurlOptionsHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author    CiGurus <gurus@groups.teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Ci\CurlBundle\Services\CurlOptionsHandler
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class CurlOptionsHandlerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var CurlOptionsHandler
     */
    private $curlOptionsHandler;

    /**
     * @var ContainerInterface
     */
    private static $container;

    /**
     * @var array
     */
    private $defaultOptions = array('CURLOPT_RETURNTRANSFER' => true);

    /**
     * {@inheritDoc}
     */
    public static function setUpBeforeClass() {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();

        static::$container = $kernel->getContainer();
    }

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
    public function serviceDefinition() {
        $curlOptionsHandler = static::$container->get('ci.curl.options.handler');
        unset($curlOptionsHandler);
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

        $this->assertSame($this->castToConstantArray(), $property->getValue($this->curlOptionsHandler));
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
        $this->assertSame($this->castToConstantArray(), $this->curlOptionsHandler->getOptions());
    }

    /**
     * @test
     * @group  small
     * @covers ::setOption
     * @covers ::<private>
     */
    public function setOption() {
        $this->assertInstanceOf(get_class($this->curlOptionsHandler), $this->curlOptionsHandler->setOption('CURLOPT_RETURNTRANSFER', false));

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
        $this->assertInstanceOf(get_class($this->curlOptionsHandler), $this->curlOptionsHandler->setOption(CURLOPT_RETURNTRANSFER, false));
    }

    /**
     * casts an option array to a constant array
     *
     * @return array
     */
    private function castToConstantArray() {
        $defaultOptions = array();
        foreach ($this->defaultOptions as $optionName => $value) {
            $defaultOptions[constant($optionName)] = $value;
        }

        return $defaultOptions;
    }

}