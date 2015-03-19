<?php

namespace Ci\CurlBundle\Tests\Functional\Services;

use Ci\CurlBundle\Services\Curl;
use Ci\CurlBundle\Services\CurlOptionsHandler;

/**
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
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
     * {@inheritDoc}
     */
    public function setUp() {
        $this->curl                 = new Curl(new CurlOptionsHandler(array(CURLOPT_RETURNTRANSFER => true)));
        $this->mockControllerUrl    = 'http://localhost/CurlBundle/web/app_dev.php/curlstub/';
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
        $response = $this->curl->sendRequest($this->mockControllerUrl . 'get', 'GET');
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
        $response = $this->curl->sendRequest($this->mockControllerUrl . 'post', 'POST');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertRegExp('/Content-Type:\s*application\/json/', $response->getContent());
    }
}