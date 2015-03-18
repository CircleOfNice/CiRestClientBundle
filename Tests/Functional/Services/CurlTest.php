<?php

namespace Ci\CurlBundle\Tests\Functional\Services;

require_once __DIR__ . '/../../../../../../app/AppKernel.php';

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