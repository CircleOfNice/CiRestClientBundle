<?php

namespace Ci\CurlBundle\Tests\Unit\Services;

require_once __DIR__ . '/../../../../../app/AppKernel.php';

use Ci\CurlBundle\Services\RestClient;
use Symfony\Component\HttpFoundation\Response;

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
     * @var Mockup<Ci\CurlBundle\Services\Curl>
     */
    private $curl;

    /**
     * {@inheritDoc}
     */
    public function setUp() {
        $this->curl                 = $this->getMockBuilder('Ci\CurlBundle\Services\Curl')->disableOriginalConstructor()->getMock();
        $this->restClient           = new RestClient($this->curl);
        $this->mockControllerUrl    = 'http://someUrl.com';
    }

    /**
     * @test
     * @group  small
     * @covers ::get
     * @covers ::<private>
     */
    public function get() {
        $response = new Response('content');
        $this->curl->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo($this->mockControllerUrl), $this->equalTo('GET'), $this->equalTo(array()))
            ->will($this->returnValue($response));

        $this->assertSame($response, $this->restClient->get($this->mockControllerUrl));
    }

    /**
     * @test
     * @group  small
     * @covers ::delete
     * @covers ::<private>
     */
    public function delete() {
        $response = new Response('content');
        $this->curl->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo($this->mockControllerUrl), $this->equalTo('DELETE'), $this->equalTo(array()))
            ->will($this->returnValue($response));

        $this->assertSame($response, $this->restClient->delete($this->mockControllerUrl));
    }

    /**
     * @test
     * @group  small
     * @covers ::post
     * @covers ::<private>
     */
    public function post() {
        $payload = 'payload';
        $response = new Response('content');
        $this->curl->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo($this->mockControllerUrl), $this->equalTo('POST'), $this->equalTo(array()), $this->equalTo($payload))
            ->will($this->returnValue($response));

        $this->assertSame($response, $this->restClient->post($this->mockControllerUrl, $payload));
    }

    /**
     * @test
     * @group  small
     * @covers ::put
     * @covers ::<private>
     */
    public function put() {
        $payload = 'payload';
        $response = new Response('content');
        $this->curl->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo($this->mockControllerUrl), $this->equalTo('PUT'), $this->equalTo(array()), $this->equalTo($payload))
            ->will($this->returnValue($response));

        $this->assertSame($response, $this->restClient->put($this->mockControllerUrl, $payload));
    }

    /**
     * @test
     * @group  small
     * @covers ::setContentType
     * @covers ::<private>
     */
    public function setContentType() {
        $contentType = 'application/json';
        $this->curl->expects($this->once())
            ->method('setContentType')
            ->with($this->equalTo($contentType));

        $this->assertInstanceOf(get_class($this->restClient), $this->restClient->setContentType($contentType));
    }
}