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

namespace Circle\RestClientBundle\Tests\Functional\Traits;

use Circle\RestClientBundle\Traits\Exceptions;

/**
 * Provides functions to get Routes and URLs for testing issues
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Circle\RestClientBundle\Traits\Exceptions
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
     * @covers Circle\RestClientBundle\Exceptions\CouldntResolveHostException
     * @covers Circle\RestClientBundle\Exceptions\CouldntResolveProxyException
     * @covers Circle\RestClientBundle\Exceptions\FailedInitException
     * @covers Circle\RestClientBundle\Exceptions\NotBuiltInException
     * @covers Circle\RestClientBundle\Exceptions\UnsupportedProtocolException
     * @covers Circle\RestClientBundle\Exceptions\UrlMalformatException
     * @covers Circle\RestClientBundle\Exceptions\CouldntConnectException
     * @covers Circle\RestClientBundle\Exceptions\FtpWeirdServerReplyException
     * @covers Circle\RestClientBundle\Exceptions\RemoteAccessDeniedException
     * @covers Circle\RestClientBundle\Exceptions\FtpAcceptFailedException
     * @covers Circle\RestClientBundle\Exceptions\FtpWeirdPassReplyException
     * @covers Circle\RestClientBundle\Exceptions\FtpAcceptTimeoutException
     * @covers Circle\RestClientBundle\Exceptions\FtpWeirdPasvReplyException
     * @covers Circle\RestClientBundle\Exceptions\FtpWeird227FormatException
     * @covers Circle\RestClientBundle\Exceptions\FtpCantGetHostException
     * @covers Circle\RestClientBundle\Exceptions\Http2Exception
     * @covers Circle\RestClientBundle\Exceptions\FtpCouldntSetTypeException
     * @covers Circle\RestClientBundle\Exceptions\PartialFileException
     * @covers Circle\RestClientBundle\Exceptions\FtpCouldntRetrFileException
     * @covers Circle\RestClientBundle\Exceptions\QuoteErrorException
     * @covers Circle\RestClientBundle\Exceptions\HttpReturnedErrorException
     * @covers Circle\RestClientBundle\Exceptions\WriteErrorException
     * @covers Circle\RestClientBundle\Exceptions\ReadErrorException
     * @covers Circle\RestClientBundle\Exceptions\UploadFailedException
     * @covers Circle\RestClientBundle\Exceptions\OutOfMemoryException
     * @covers Circle\RestClientBundle\Exceptions\OperationTimedOutException
     * @covers Circle\RestClientBundle\Exceptions\FtpPortFailedException
     * @covers Circle\RestClientBundle\Exceptions\FtpCouldntUseRestException
     * @covers Circle\RestClientBundle\Exceptions\RangeErrorException
     * @covers Circle\RestClientBundle\Exceptions\HttpPostErrorException
     * @covers Circle\RestClientBundle\Exceptions\SslConnectErrorException
     * @covers Circle\RestClientBundle\Exceptions\BadDownloadResumeException
     * @covers Circle\RestClientBundle\Exceptions\FileCouldntReadFileException
     * @covers Circle\RestClientBundle\Exceptions\LdapCannotBindException
     * @covers Circle\RestClientBundle\Exceptions\LdapSearchFailedException
     * @covers Circle\RestClientBundle\Exceptions\FunctionNotFoundException
     * @covers Circle\RestClientBundle\Exceptions\AbortedByCallbackException
     * @covers Circle\RestClientBundle\Exceptions\BadFunctionArgumentException
     * @covers Circle\RestClientBundle\Exceptions\InterfaceFailedException
     * @covers Circle\RestClientBundle\Exceptions\TooManyRedirectsException
     * @covers Circle\RestClientBundle\Exceptions\UnknownOptionException
     * @covers Circle\RestClientBundle\Exceptions\TelnetOptionSyntaxException
     * @covers Circle\RestClientBundle\Exceptions\PeerFailedverificationException
     * @covers Circle\RestClientBundle\Exceptions\GotNothingException
     * @covers Circle\RestClientBundle\Exceptions\SslEngineNotFoundException
     * @covers Circle\RestClientBundle\Exceptions\SslEngineSetFailedException
     * @covers Circle\RestClientBundle\Exceptions\SendErrorException
     * @covers Circle\RestClientBundle\Exceptions\RecvErrorException
     * @covers Circle\RestClientBundle\Exceptions\SslCertProblemException
     * @covers Circle\RestClientBundle\Exceptions\SslCipherException
     * @covers Circle\RestClientBundle\Exceptions\SslCacertException
     * @covers Circle\RestClientBundle\Exceptions\BadContentEncodingException
     * @covers Circle\RestClientBundle\Exceptions\LdapInvalidUrlException
     * @covers Circle\RestClientBundle\Exceptions\FilesizeExceededException
     * @covers Circle\RestClientBundle\Exceptions\UseSslFailedException
     * @covers Circle\RestClientBundle\Exceptions\SendFailRewindException
     * @covers Circle\RestClientBundle\Exceptions\SslEngineInitFailedException
     * @covers Circle\RestClientBundle\Exceptions\LoginDeniedException
     * @covers Circle\RestClientBundle\Exceptions\TftpNotFoundException
     * @covers Circle\RestClientBundle\Exceptions\TftpPermException
     * @covers Circle\RestClientBundle\Exceptions\RemoteDiskFullException
     * @covers Circle\RestClientBundle\Exceptions\SslCacertBadfileException
     * @covers Circle\RestClientBundle\Exceptions\RemoteFileNotFoundException
     * @covers Circle\RestClientBundle\Exceptions\SshException
     * @covers Circle\RestClientBundle\Exceptions\SslShutdownFailedException
     * @covers Circle\RestClientBundle\Exceptions\AgainException
     * @covers Circle\RestClientBundle\Exceptions\SslCrlBadfileException
     * @covers Circle\RestClientBundle\Exceptions\SslIssuerErrorException
     * @covers Circle\RestClientBundle\Exceptions\FtpPretFailedException
     * @covers Circle\RestClientBundle\Exceptions\RtspCseqErrorException
     * @covers Circle\RestClientBundle\Exceptions\RtspSessionErrorException
     * @covers Circle\RestClientBundle\Exceptions\FtpBadFileListException
     * @covers Circle\RestClientBundle\Exceptions\ChunkFailedException
     * @covers Circle\RestClientBundle\Exceptions\ConvFailedException
     * @covers Circle\RestClientBundle\Exceptions\ConvReqdException
     * @covers Circle\RestClientBundle\Exceptions\RemoteFileExistsException
     * @covers Circle\RestClientBundle\Exceptions\TftpIllegalException
     * @covers Circle\RestClientBundle\Exceptions\TftpNoSuchUserException
     * @covers Circle\RestClientBundle\Exceptions\TftpUnknownIdException
     */
    public function curlExceptionTest() {
        $this->assertExpectedCurlException(999, 'Circle\RestClientBundle\Exceptions\CurlException');

        foreach ($this->getExceptionCodeMappings() as $errorCode => $exceptionNamespace) {
            $exceptionNamespace = 'Circle\RestClientBundle\Exceptions\\' . $exceptionNamespace;
            $this->assertExpectedCurlException($errorCode, $exceptionNamespace);

            $exception = new $exceptionNamespace();
            $this->assertSame($errorCode, $exception->getCode());
            $this->assertInstanceOf('Circle\RestClientBundle\Exceptions\Interfaces\DetailedExceptionInterface', $exception);
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