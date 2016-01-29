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
class FtpAcceptTimeoutException extends CurlException implements DetailedExceptionInterface {

    /**
     * Sets all necessary dependencies
     */
    public function __construct() {
        $message = 'During an active FTP session while waiting for the server to connect, ' .
            'the CURLOPT_ACCEPTTIMOUT_MS(3) (or the internal default) timeout expired';
        $code    = 12;
        parent::__construct($message, $code);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getDetailedMessage() {
        return 'During an active FTP session while waiting for the server to connect, ' .
        'the CURLOPT_ACCEPTTIMOUT_MS(3) (or the internal default) timeout expired.';
    }
}