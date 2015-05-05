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

namespace Ci\RestClientBundle\Traits;

use Ci\RestClientBundle\Exceptions as CurlExceptions;

/**
 * Provides exception functions
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
trait Exceptions {

    private $exceptionsNamespace = 'Ci\RestClientBundle\Exceptions';

    /**
     * returns all curl error codes and their related exception classes
     *
     * @return array[$errorCode => $namespace]
     */
    private function getExceptionCodeMappings() {
        return array(
            1 => 'UnsupportedProtocolException',
            2 => 'FailedInitException',
            3 => 'UrlMalformatException',
            4 => 'NotBuiltInException',
            5 => 'CouldntResolveProxyException',
            6 => 'CouldntResolveHostException'
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
            $exceptionClass . ' does not exist. Check class var $exceptionCodeMappings in Ci\RestClientBundle\Traits\Exceptions.'
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