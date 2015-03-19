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

namespace Ci\RestClientBundle\Traits;

use Ci\RestClientBundle\Exceptions\CurlException;

/**
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
trait Exceptions {

    /**
     * throws a curl exception
     *
     * @param  string $message
     * @param  int    $code
     * @throws CurlException
     */
    private function curlException($message, $code) {
        throw new CurlException("Error: {$message} and the Error no is: {$code} ", $code);
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