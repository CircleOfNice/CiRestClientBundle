<?php
/**
 * This file is part of CircleRestClientBundle.
 *
 * CircleRestClientBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CircleRestClientBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CircleRestClientBundle.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Circle\RestClientBundle\Tests\Functional\Services;

use Circle\RestClientBundle\Services\CurlOptionsHandler;

/**
 * Tests the curl options handler
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Circle\RestClientBundle\Services\CurlOptionsHandler
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
        $reflectionClass    = new \ReflectionClass($this->curlOptionsHandler);
        $property           = $reflectionClass->getProperty('options');
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