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

namespace Circle\RestClientBundle\Traits;

use Circle\RestClientBundle\Exceptions as CurlExceptions;

/**
 * Provides exception functions
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
trait Exceptions {

    private $exceptionsNamespace = 'Circle\RestClientBundle\Exceptions';

    /**
     * returns all curl error codes and their related exception classes
     *
     * @return array[$errorCode => $namespace]
     */
    private function getExceptionCodeMappings() {
        return array(
            1   => 'UnsupportedProtocolException',
            2   => 'FailedInitException',
            3   => 'UrlMalformatException',
            4   => 'NotBuiltInException',
            5   => 'CouldntResolveProxyException',
            6   => 'CouldntResolveHostException',
            7   => 'CouldntConnectException',
            8   => 'FtpWeirdServerReplyException',
            9   => 'RemoteAccessDeniedException',
            10  => 'FtpAcceptFailedException',
            11  => 'FtpWeirdPassReplyException',
            12  => 'FtpAcceptTimeoutException',
            13  => 'FtpWeirdPasvReplyException',
            14  => 'FtpWeird227FormatException',
            15  => 'FtpCantGetHostException',
            16  => 'Http2Exception',
            17  => 'FtpCouldntSetTypeException',
            18  => 'PartialFileException',
            19  => 'FtpCouldntRetrFileException',
            21  => 'QuoteErrorException',
            22  => 'HttpReturnedErrorException',
            23  => 'WriteErrorException',
            25  => 'UploadFailedException',
            26  => 'ReadErrorException',
            27  => 'OutOfMemoryException',
            28  => 'OperationTimedOutException',
            30  => 'FtpPortFailedException',
            31  => 'FtpCouldntUseRestException',
            33  => 'RangeErrorException',
            34  => 'HttpPostErrorException',
            35  => 'SslConnectErrorException',
            36  => 'BadDownloadResumeException',
            37  => 'FileCouldntReadFileException',
            38  => 'LdapCannotBindException',
            39  => 'LdapSearchFailedException',
            41  => 'FunctionNotFoundException',
            42  => 'AbortedByCallbackException',
            43  => 'BadFunctionArgumentException',
            45  => 'InterfaceFailedException',
            47  => 'TooManyRedirectsException',
            48  => 'UnknownOptionException',
            49  => 'TelnetOptionSyntaxException',
            51  => 'PeerFailedVerificationException',
            52  => 'GotNothingException',
            53  => 'SslEngineNotFoundException',
            54  => 'SslEngineSetFailedException',
            55  => 'SendErrorException',
            56  => 'RecvErrorException',
            58  => 'SslCertProblemException',
            59  => 'SslCipherException',
            60  => 'SslCacertException',
            61  => 'BadContentEncodingException',
            62  => 'LdapInvalidUrlException',
            63  => 'FilesizeExceededException',
            64  => 'UseSslFailedException',
            65  => 'SendFailRewindException',
            66  => 'SslEngineInitFailedException',
            67  => 'LoginDeniedException',
            68  => 'TftpNotFoundException',
            69  => 'TftpPermException',
            70  => 'RemoteDiskFullException',
            71  => 'TftpIllegalException',
            72  => 'TftpUnknownIdException',
            73  => 'RemoteFileExistsException',
            74  => 'TftpNoSuchUserException',
            75  => 'ConvFailedException',
            76  => 'ConvReqdException',
            77  => 'SslCacertBadfileException',
            78  => 'RemoteFileNotFoundException',
            79  => 'SshException',
            80  => 'SslShutdownFailedException',
            81  => 'AgainException',
            82  => 'SslCrlBadfileException',
            83  => 'SslIssuerErrorException',
            84  => 'FtpPretFailedException',
            85  => 'RtspCseqErrorException',
            86  => 'RtspSessionErrorException',
            87  => 'FtpBadFileListException',
            88  => 'ChunkFailedException'
        );
    }

    /**
     * throws a curl exception
     *
     * @param  string $message
     * @param  int    $code
     * @throws CurlExceptions\CurlException | \RuntimeException
     */
    private function curlException($message, $code) {
        if (!array_key_exists($code, $this->getExceptionCodeMappings())) throw new CurlExceptions\CurlException("Error: {$message} and the Error no is: {$code} ", $code);

        $exceptionClass = $this->exceptionsNamespace . '\\' . $this->getExceptionCodeMappings()[$code];
        if (!class_exists($exceptionClass)) throw new \RuntimeException(
            $exceptionClass . ' does not exist. Check class var $exceptionCodeMappings in Circle\RestClientBundle\Traits\Exceptions.'
        );
        throw new $exceptionClass($message, $code);

    }

    /**
     * throws an invalid argument exception
     *
     * @param  $message
     * @throws \InvalidArgumentException
     */
    private function invalidArgumentException($message) {
        throw new \InvalidArgumentException($message);
    }
}