<?php
/**
 * This file is part of CiRestClientBundle.
 *
 * CiRestClientBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CiRestClientBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CiRestClientBundle.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Ci\RestClientBundle\Tests\Functional\Traits;

use Ci\RestClientBundle\Traits\Exceptions;

/**
 * Provides functions to get Routes and URLs for testing issues
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Ci\RestClientBundle\Traits\Exceptions
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class ExceptionsTest extends \PHPUnit_Framework_TestCase {

    use Exceptions;

    /**
     * @test
     * @group  small
     * @covers ::curlException
     * @covers ::getExceptionCodeMappings
     * @covers Ci\RestClientBundle\Exceptions\CouldntResolveHostException
     * @covers Ci\RestClientBundle\Exceptions\CouldntResolveProxyException
     * @covers Ci\RestClientBundle\Exceptions\FailedInitException
     * @covers Ci\RestClientBundle\Exceptions\NotBuiltInException
     * @covers Ci\RestClientBundle\Exceptions\UnsupportedProtocolException
     * @covers Ci\RestClientBundle\Exceptions\UrlMalformatException
     * @covers Ci\RestClientBundle\Exceptions\CouldntConnectException
     * @covers Ci\RestClientBundle\Exceptions\FtpWeirdServerReplyException
     * @covers Ci\RestClientBundle\Exceptions\RemoteAccessDeniedException
     * @covers Ci\RestClientBundle\Exceptions\FtpAcceptFailedException
     * @covers Ci\RestClientBundle\Exceptions\FtpWeirdPassReplyException
     * @covers Ci\RestClientBundle\Exceptions\FtpAcceptTimeoutException
     * @covers Ci\RestClientBundle\Exceptions\FtpWeirdPasvReplyException
     * @covers Ci\RestClientBundle\Exceptions\FtpWeird227FormatException
     * @covers Ci\RestClientBundle\Exceptions\FtpCantGetHostException
     * @covers Ci\RestClientBundle\Exceptions\Http2Exception
     * @covers Ci\RestClientBundle\Exceptions\FtpCouldntSetTypeException
     * @covers Ci\RestClientBundle\Exceptions\PartialFileException
     * @covers Ci\RestClientBundle\Exceptions\FtpCouldntRetrFileException
     * @covers Ci\RestClientBundle\Exceptions\QuoteErrorException
     * @covers Ci\RestClientBundle\Exceptions\HttpReturnedErrorException
     * @covers Ci\RestClientBundle\Exceptions\WriteErrorException
     * @covers Ci\RestClientBundle\Exceptions\ReadErrorException
     * @covers Ci\RestClientBundle\Exceptions\UploadFailedException
     * @covers Ci\RestClientBundle\Exceptions\OutOfMemoryException
     * @covers Ci\RestClientBundle\Exceptions\OperationTimedOutException
     * @covers Ci\RestClientBundle\Exceptions\FtpPortFailedException
     * @covers Ci\RestClientBundle\Exceptions\FtpCouldntUseRestException
     * @covers Ci\RestClientBundle\Exceptions\RangeErrorException
     * @covers Ci\RestClientBundle\Exceptions\HttpPostErrorException
     * @covers Ci\RestClientBundle\Exceptions\SslConnectErrorException
     * @covers Ci\RestClientBundle\Exceptions\BadDownloadResumeException
     * @covers Ci\RestClientBundle\Exceptions\FileCouldntReadFileException
     * @covers Ci\RestClientBundle\Exceptions\LdapCannotBindException
     * @covers Ci\RestClientBundle\Exceptions\LdapSearchFailedException
     * @covers Ci\RestClientBundle\Exceptions\FunctionNotFoundException
     * @covers Ci\RestClientBundle\Exceptions\AbortedByCallbackException
     * @covers Ci\RestClientBundle\Exceptions\BadFunctionArgumentException
     * @covers Ci\RestClientBundle\Exceptions\InterfaceFailedException
     * @covers Ci\RestClientBundle\Exceptions\TooManyRedirectsException
     * @covers Ci\RestClientBundle\Exceptions\UnknownOptionException
     * @covers Ci\RestClientBundle\Exceptions\TelnetOptionSyntaxException
     * @covers Ci\RestClientBundle\Exceptions\PeerFailedverificationException
     */
    public function curlExceptionTest() {
        $this->assertExpectedCurlException(999, 'Ci\RestClientBundle\Exceptions\CurlException');

        foreach ($this->getExceptionCodeMappings() as $errorCode => $exceptionNamespace) {
            $exceptionNamespace = 'Ci\RestClientBundle\Exceptions\\' . $exceptionNamespace;
            $this->assertExpectedCurlException($errorCode, $exceptionNamespace);

            $exception = new $exceptionNamespace();
            $this->assertSame($errorCode, $exception->getCode());
            $this->assertInstanceOf('Ci\RestClientBundle\Exceptions\Interfaces\DetailedExceptionInterface', $exception);
        }
    }

    /**
     * @test
     * @group  small
     * @covers ::curlException
     *
     * @expectedException \RuntimeException
     */
    public function curlExceptionOnRuntimeException() {
        $this->exceptionsNamespace = 'Wrong\Namespace';

        $this->curlException('Some message', 1);
    }

    /**
     * Helper function to avoid creating new methods for each exception type check
     *
     * @param int    $errorCode
     * @param string $exception
     */
    private function assertExpectedCurlException($errorCode, $exception) {
        try {
            $this->curlException('Some Message', $errorCode);
        } catch(\Exception $e) {
            $this->assertSame($exception, get_class($e));
        }
    }
}