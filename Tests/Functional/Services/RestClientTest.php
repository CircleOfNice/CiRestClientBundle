<?php

namespace Ci\CurlBundle\Tests\Functional\Services;

use Ci\CurlBundle\Services\RestClient;
use Ci\CurlBundle\Services\Curl;
use Ci\CurlBundle\Services\CurlOptionsHandler;

/**
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Ci\CurlBundle\Services\RestClient
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class RestClientTest extends \PHPUnit_Framework_TestCase {

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
        $this->mockControllerUrl = 'http://localhost/CurlBundle/web/app_dev.php/curlstub/';
    }

    /**
     * @test
     * @group  small
     * @covers ::__construct
     * @covers ::<private>
     */
    public function construct() {
        $this->assertInstanceOf('Ci\CurlBundle\Services\RestClient', $this->restClient);
    }

    /**
     * @test
     * @group  small
     * @covers ::get
     * @covers ::<private>
     */
    public function getOnSuccess() {
        $response = $this->restClient->get($this->mockControllerUrl . 'get');
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
        $response = $this->restClient->get($this->mockControllerUrl . 'get?httpCode=400');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::get
     * @covers ::<private>
     *
     * @expectedException \Ci\CurlBundle\Exceptions\CurlException
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
        $response = $this->restClient->post($this->mockControllerUrl . 'post', 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(is_string($response->getContent()));
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @uses   Ci\CurlBundle\Services\RestClient::post
     * @covers ::setContentType
     * @covers ::<private>
     */
    public function setContentType() {
        $this->restClient->setContentType('application/json');
        $response = $this->restClient->post($this->mockControllerUrl . 'post', 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertRegExp('/Content-Type:\s*application\/json/', $response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::post
     * @covers ::<private>
     */
    public function postOnError() {
        $response = $this->restClient->post($this->mockControllerUrl . 'post?httpCode=400', 'payload');
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
        $response = $this->restClient->put($this->mockControllerUrl . 'put', 'payload');
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
        $response = $this->restClient->put($this->mockControllerUrl . 'put?httpCode=400', 'payload');
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
        $response = $this->restClient->delete($this->mockControllerUrl . 'delete');
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
        $response = $this->restClient->delete($this->mockControllerUrl . 'delete?httpCode=400');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::head
     * @covers ::<private>
     */
    public function head() {
        $response = $this->restClient->head($this->mockControllerUrl . 'head?httpCode=200');
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
        $response = $this->restClient->options($this->mockControllerUrl . 'options?httpCode=200', 'test');
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
        $response = $this->restClient->trace($this->mockControllerUrl . 'trace?httpCode=405');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(405, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::connect
     * @covers ::<private>
     */
    public function connect() {
        $response = $this->restClient->connect($this->mockControllerUrl . 'connect?httpCode=400');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @covers ::patch
     * @covers ::<private>
     */
    public function patch() {
        $response = $this->restClient->patch($this->mockControllerUrl . 'patch?httpCode=200', 'test');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }
}