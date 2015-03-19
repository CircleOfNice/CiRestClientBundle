<?php

namespace Ci\CurlBundle\Tests\Functional\Services;

use Ci\CurlBundle\Services\Curl;
use Ci\CurlBundle\Services\CurlOptionsHandler;
use Ci\CurlBundle\Tests\Functional\Traits\TestingParameters;

/**
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Ci\CurlBundle\Services\Curl
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class CurlTest extends \PHPUnit_Framework_TestCase {

    use TestingParameters;

    /**
     * @var string
     */
    private $mockControllerUrl;

    /**
     * @var Curl
     */
    private $curl;

    /**
     * {@inheritDoc}
     */
    public function setUp() {
        $this->curl = new Curl(new CurlOptionsHandler(array()));
        $this->mockControllerUrl = $this->getMockControllerUrl();
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
     * @covers ::sendRequest
     * @covers ::<private>
     */
    public function sendRequest() {
        $response = $this->curl->sendRequest($this->mockControllerUrl, 'GET');
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::sendRequest
     * @covers ::<private>
     *
     * @expectedException \Ci\CurlBundle\Exceptions\CurlException
     */
    public function sendRequestOnError() {
        $this->curl->sendRequest('http://missinghostthatwillneverbecomearealhost.it', 'GET');
    }

    /**
     * @test
     * @group  small
     * @uses   Ci\CurlBundle\Services\RestClient::post
     * @covers ::setContentType
     * @covers ::<private>
     */
    public function setContentType() {
        $this->curl->setContentType('application/json');
        $response = $this->curl->sendRequest($this->mockControllerUrl, 'POST');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
    }
}