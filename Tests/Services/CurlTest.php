<?php

namespace Ci\CurlBundle\Tests\Services;

require_once __DIR__ . '/../../../../../app/AppKernel.php';

use Ci\CurlBundle\Services\Curl;
use Ci\CurlBundle\Services\CurlOptionsHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author    CiGurus <gurus@groups.teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Ci\CurlBundle\Services\Curl
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class CurlTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var string
     */
    private $mockControllerUrl;

    /**
     * @var Curl
     */
    private $curl;

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
        $this->curl                 = static::$container->get('ci.curl');
        $this->mockControllerUrl    = static::$container->getParameter('ci.curl.testing_url') . '/curlstub/';
    }

    /**
     * @test
     * @group  small
     * @covers ::__construct
     * @covers ::<private>
     * @covers ::__destruct
     */
    public function constructAndDestroy() {
        $curl = new Curl(new CurlOptionsHandler(array()));
        unset($curl);
    }

    /**
     * @test
     * @group  small
     * @covers ::get
     * @covers ::<private>
     */
    public function getOnSuccess() {
        $response = $this->curl->get($this->mockControllerUrl . 'get');
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
        $response = $this->curl->get($this->mockControllerUrl . 'get?httpCode=400');
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
    public function nonExistingUrl() {
        $response = $this->curl->get('noUrl');
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
        $response = $this->curl->post($this->mockControllerUrl . 'post', 'payload');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(is_string($response->getContent()));
        $this->assertNotNull($response->getContent());
    }

    /**
     * @test
     * @group  small
     * @uses   Ci\CurlBundle\Services\Curl::post
     * @covers ::setContentType
     * @covers ::<private>
     */
    public function setContentType() {
        $this->curl->setContentType('application/json');
        $response = $this->curl->post($this->mockControllerUrl . 'post', 'payload');
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
        $response = $this->curl->post($this->mockControllerUrl . 'post?httpCode=400', 'payload');
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
        $response = $this->curl->put($this->mockControllerUrl . 'put', 'payload');
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
        $response = $this->curl->put($this->mockControllerUrl . 'put?httpCode=400', 'payload');
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
        $response = $this->curl->delete($this->mockControllerUrl . 'delete');
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
        $response = $this->curl->delete($this->mockControllerUrl . 'delete?httpCode=400');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEquals(200, $response->getStatusCode());
    }
}