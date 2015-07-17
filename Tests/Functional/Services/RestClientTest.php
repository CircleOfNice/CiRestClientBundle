<?php
/**
 * This file is part of CiRestClientBundle.
 *
 * CiRestClientBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CiRestClientBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CiRestClientBundle.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Ci\RestClientBundle\Tests\Functional\Services;

use Ci\RestClientBundle\Services\RestClient;
use Ci\RestClientBundle\Services\Curl;
use Ci\RestClientBundle\Services\CurlOptionsHandler;
use Ci\RestClientBundle\Tests\Functional\Traits\TestingRoutes;

/**
 * Tests the rest client
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Ci\RestClientBundle\Services\RestClient
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class RestClientTest extends \PHPUnit_Framework_TestCase {

    use TestingRoutes;

    /**
     * @var string
     */
    private $mockControllerUrl;

    /**
     * @var RestClient
     */
    private $restClient;

    /**
     * {@inheritDoc}
     */
    public function setUp() {
        $this->restClient        = new RestClient(new Curl(new CurlOptionsHandler(array(CURLOPT_RETURNTRANSFER => true))));
        $this->mockControllerUrl = $this->getMockControllerUrl();
    }

    /**
     * @test
     * @group  small
     * @covers ::__construct
     * @covers ::<private>
     */
    public function construct() {
        $this->assertInstanceOf('Ci\RestClientBundle\Services\RestClient', $this->restClient);
    }

    /**
     * @test
     * @group  small
     * @covers ::get
     * @covers ::<private>
     */
    public function get() {
        $response = $this->restClient->get($this->getHTTP200Route());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(is_string($response->getContent()));
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::get
     * @covers ::<private>
     */
    public function getOnError() {
        $response = $this->restClient->get($this->getHTTP404Route());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::get
     * @covers ::<private>
     *
     * @expectedException \Ci\RestClientBundle\Exceptions\CurlException
     */
    public function nonExistingUrl() {
        $response = $this->restClient->get('http://missinghostthatwillneverbecomearealhost.it');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::get
     * @covers ::<private>
     *
     * @expectedException \InvalidArgumentException
     */
    public function wrongUrl() {
        $response = $this->restClient->get('noUrl');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::post
     * @covers ::<private>
     */
    public function post() {
        $response = $this->restClient->post($this->getHTTP200Route(), 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(is_string($response->getContent()));
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @uses   Ci\RestClientBundle\Services\RestClient::post
     * @covers ::setContentType
     * @covers ::<private>
     */
    public function setContentType() {
        $this->restClient->setContentType('application/json');
        $response = $this->restClient->post($this->getHTTP200Route(), 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
    }

    /**
     * @test
     * @group  small
     * @covers ::post
     * @covers ::<private>
     */
    public function postOnError() {
        $response = $this->restClient->post($this->getHTTP404Route(), 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::put
     * @covers ::<private>
     */
    public function put() {
        $response = $this->restClient->put($this->getHTTP200Route(), 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(is_string($response->getContent()));
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::put
     * @covers ::<private>
     */
    public function putOnError() {
        $response = $this->restClient->put($this->getHTTP404Route(), 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::delete
     * @covers ::<private>
     */
    public function delete() {
        $response = $this->restClient->delete($this->getHTTP200Route());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(is_string($response->getContent()));
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::delete
     * @covers ::<private>
     */
    public function deleteOnError() {
        $response = $this->restClient->delete($this->getHTTP404Route());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::head
     * @covers ::<private>
     */
    public function head() {
        $response = $this->restClient->head($this->getHTTP200Route(), array());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::options
     * @covers ::<private>
     */
    public function options() {
        $response = $this->restClient->options($this->getHTTP200Route(), 'test');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::trace
     * @covers ::<private>
     */
    public function trace() {
        $response = $this->restClient->trace($this->getHTTP200Route());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::connect
     * @covers ::<private>
     *
     * @expectedException \Ci\RestClientBundle\Exceptions\CurlException
     */
    public function connect() {
        $this->restClient->connect($this->getHTTP200Route());
    }

    /**
     * @test
     * @group  small
     * @covers ::patch
     * @covers ::<private>
     */
    public function patch() {
        $response = $this->restClient->patch($this->getHTTP200Route(), 'test');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::link
     * @covers ::<private>
     */
    public function linkOnError() {
        $response = $this->restClient->link($this->getMockControllerUrl() . '/Mock.png');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(501, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::unlink
     * @covers ::<private>
     */
    public function unlinkOnError() {
        $response = $this->restClient->unlink($this->getMockControllerUrl() . '/Mock.png');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(501, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }
}