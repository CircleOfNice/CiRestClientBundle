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

namespace Ci\RestClientBundle\Exceptions;

use Ci\RestClientBundle\Exceptions\Interfaces\DetailedExceptionInterface;

/**
 * Specific exception for curl requests
 *
 * Explanations given in function getDetailedMessage
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class SslConnectErrorException extends CurlException implements DetailedExceptionInterface {

    /**
     * Sets all necessary dependencies
     */
    public function __construct() {
        $message = 'A problem occurred somewhere in the SSL/TLS handshake';
        $code    = 35;
        parent::__construct($message, $code);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getDetailedMessage() {
        return 'A problem occurred somewhere in the SSL/TLS handshake. You really want the ' .
        'error buffer and read the message there as it pinpoints the problem slightly more. ' .
        'Could be certificates (file formats, paths, permissions), passwords, and others.';
    }
}