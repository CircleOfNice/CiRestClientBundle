<?php
/**
 * This file is part of CircleRestClientBundle.
 *
 * CircleRestClientBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CircleRestClientBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CircleRestClientBundle.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Circle\RestClientBundle\Tests\Functional\Parsers;

use Circle\RestClientBundle\Parsers\HTTPHeadersParser;

/**
 * Tests the HTTPHeadersParser class
 *
 * @author    Timo Linde <info@timo-linde.de>
 * @copyright 2016 TeeAge-Beatz UG
 *
 * @coversDefaultClass Circle\RestClientBundle\Parsers\HTTPHeadersParser
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class ResponseHeadersTest extends \PHPUnit_Framework_TestCase {    
    
    /**
     * @test
     * @covers ::parse
     */
    public function testParse() {
        $headers = "HTTP/1.1 302 Found\r\n".
            "Date: Tue, 21 Apr 2015 13:57:48 GMT\r\n".
            "Server: Apache/2.2.22 (Debian)\r\n".
            "Location: https://test.de\r\n".
            "Vary: Accept-Encoding\r\n".
            "Content-Length: 284\r\n".
            "Content-Type: text/html; charset=iso-8859-1\r\n";
        
        $parsedHeader = HTTPHeadersParser::parse($headers);
        $this->assertArrayHasKey('Date', $parsedHeader);
        $this->assertArrayHasKey('Server', $parsedHeader);
        $this->assertArrayHasKey('Location', $parsedHeader);
        $this->assertArrayHasKey('Vary', $parsedHeader);
        $this->assertArrayHasKey('Content-Length', $parsedHeader);
        $this->assertArrayHasKey('Content-Type', $parsedHeader);
        $this->assertEquals("Tue, 21 Apr 2015 13:57:48 GMT", $parsedHeader["Date"]);
        $this->assertEquals("Apache/2.2.22 (Debian)", $parsedHeader["Server"]);
        $this->assertEquals("https://test.de", $parsedHeader["Location"]);
        $this->assertEquals("Accept-Encoding", $parsedHeader["Vary"]);
        $this->assertEquals("284", $parsedHeader["Content-Length"]);
        $this->assertEquals("text/html; charset=iso-8859-1", $parsedHeader["Content-Type"]);
    }
    
    /**
     * @test
     * @covers ::parse
     */
    public function testParseCookie() {
        $headers = "Set-Cookie: foo=bar\r\n".
            "Set-Cookie: baz=quux\r\n";
        $returnValue = HTTPHeadersParser::parse($headers);
        $this->assertTrue(is_array($returnValue));
        
        $this->assertTrue(isset($returnValue['Set-Cookie']));
        $this->assertTrue(is_array($returnValue['Set-Cookie']));
        $this->assertEquals(count($returnValue['Set-Cookie']), 2);
    }
    
    /**
     * @test
     * @covers ::parse
     */
    public function testParseFolded() {
        $headers = "Folded: works\r\n\ttoo\r\n";
        $returnValue = HTTPHeadersParser::parse($headers);
        $this->assertTrue(is_array($returnValue));
        
        $this->assertTrue(isset($returnValue['Folded']));
        $this->assertEquals($returnValue['Folded'], "works too");
    }
}