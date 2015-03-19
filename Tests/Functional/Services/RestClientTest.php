<?php

namespace Ci\RestClientBundle\Tests\Functional\Services;

use Ci\RestClientBundle\Services\RestClient;
use Ci\RestClientBundle\Services\Curl;
use Ci\RestClientBundle\Services\CurlOptionsHandler;
use Ci\RestClientBundle\Tests\Functional\Traits\TestingParameters;

/**
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Ci\RestClientBundle\Services\RestClient
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class RestClientTest extends \PHPUnit_Framework_TestCase {

    use TestingParameters;

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
    public function getOnSuccess() {
        $response = $this->restClient->get($this->mockControllerUrl);
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
        $response = $this->restClient->get($this->mockControllerUrl . '/nonExistingRoute');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEquals(200, $response->getStatusCode());
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
    public function postOnSuccess() {
        $response = $this->restClient->post($this->mockControllerUrl, 'payload');
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
        $response = $this->restClient->post($this->mockControllerUrl, 'payload');
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
        $response = $this->restClient->post($this->mockControllerUrl . '/nonExistingRoute', 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::put
     * @covers ::<private>
     */
    public function putOnSuccess() {
        $response = $this->restClient->put($this->mockControllerUrl, 'payload');
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
        $response = $this->restClient->put($this->mockControllerUrl . '/nonExistingRoute', 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::delete
     * @covers ::<private>
     */
    public function deleteOnSuccess() {
        $response = $this->restClient->delete($this->mockControllerUrl);
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
        $response = $this->restClient->delete($this->mockControllerUrl . '/nonExistingRoute');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::head
     * @covers ::<private>
     *
     * @expectedException \Ci\RestClientBundle\Exceptions\CurlException
     */
    public function head() {
        $this->restClient->head($this->mockControllerUrl, array(CURLOPT_TIMEOUT => 1, CURLOPT_MAXREDIRS => 1, CURLOPT_CONNECTTIMEOUT => 1));
    }

    /**
     * @test
     * @group  small
     * @covers ::options
     * @covers ::<private>
     */
    public function options() {
        $response = $this->restClient->options($this->mockControllerUrl, 'test');
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
        $response = $this->restClient->trace($this->mockControllerUrl);
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
        $this->restClient->connect($this->mockControllerUrl);
    }

    /**
     * @test
     * @group  small
     * @covers ::patch
     * @covers ::<private>
     */
    public function patch() {
        $response = $this->restClient->patch($this->mockControllerUrl, 'test');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }
}