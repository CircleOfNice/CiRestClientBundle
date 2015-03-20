<?php
/**
 * This file is part of GPL.
 *
 * GPL is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GPL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GPL.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Ci\RestClientBundle\Tests\Functional\Services;

use Ci\RestClientBundle\Services\Curl;
use Ci\RestClientBundle\Services\CurlOptionsHandler;
use Ci\RestClientBundle\Tests\Functional\Traits\TestingRoutes;

/**
 * Tests the curl class
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Ci\RestClientBundle\Services\Curl
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class CurlTest extends \PHPUnit_Framework_TestCase {

    use TestingRoutes;

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
        $this->curl                 = new Curl(new CurlOptionsHandler(array()));
        $this->mockControllerUrl    = $this->getMockControllerUrl();
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
        $response = $this->curl->sendRequest($this->getHTTP200Route('get'), 'GET');
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @test
     * @group  small
     * @covers ::sendRequest
     * @covers ::<private>
     *
     * @expectedException \Ci\RestClientBundle\Exceptions\CurlException
     */
    public function sendRequestOnError() {
        $this->curl->sendRequest('http://missinghostthatwillneverbecomearealhost.it', 'GET');
    }

    /**
     * @test
     * @group  small
     * @uses   Ci\RestClientBundle\Services\RestClient::post
     * @covers ::setContentType
     * @covers ::<private>
     */
    public function setContentType() {
        $this->curl->setContentType('application/json');
        $response = $this->curl->sendRequest($this->getHTTP200Route('post'), 'POST');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
    }
}