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

namespace Circle\RestClientBundle\Exceptions;

use Circle\RestClientBundle\Exceptions\Interfaces\DetailedExceptionInterface;

/**
 * Specific exception for curl requests
 *
 * Explanations given in function getDetailedMessage
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class FtpWeirdServerReplyException extends CurlException implements DetailedExceptionInterface {

    /**
     * Sets all necessary dependencies
     */
    public function __construct() {
        $message = 'After connecting to a FTP server, libcurl expects to get a certain reply back';
        $code    = 8;
        parent::__construct($message, $code);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getDetailedMessage() {
        return 'After connecting to a FTP server, libcurl expects to get a certain reply back. ' .
        'This error code implies that it got a strange or bad reply. The given remote server is probably not an OK FTP server.';
    }
}