<?php

namespace Ci\CurlBundle\Tests\Functional\Services;

require_once __DIR__ . '/../../../../../../app/AppKernel.php';

use Ci\CurlBundle\Services\RestClient;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author    CiGurus <gurus@groups.teeage-beatz.de>
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
     * @var ContainerInterface
     */
    private static $container;

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
        $this->restClient        = static::$container->get('ci.restclient');
        $this->mockControllerUrl = static::$container->getParameter('ci.curl.testing_url') . '/curlstub/';
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
        $this->assertNotNull($response->getContent());
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
        $this->assertNotNull($response->getContent());
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
        $this->assertNotNull($response->getContent());
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
        $this->assertNotNull($response->getContent());
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


}