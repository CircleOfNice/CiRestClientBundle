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

/**
 * Provides assertion functions
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
trait Assertions {

    /**
     * validates an url
     *
     * @param  string $url
     * @return $this
     */
    private function assertUrl($url) {
        if (!$this->assertString($url)) return false;
        return preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $url);
    }

    /**
     * asserts if a value is a valid string
     *
     * @param  string $value
     * @return $this
     */
    private function assertString($value) {
        if (!is_string($value)) return false;
        return true;
    }

    /**
     * asserts a http method
     *
     * @param  string $method
     * @return $this
     */
    private function assertHttpMethod($method) {
        if (!$this->assertString($method)) return false;
        $validHttpMethods = array(
            'GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS', 'TRACE', 'CONNECT', 'PATCH', 'LINK', 'UNLINK'
        );
        if (!in_array($method, $validHttpMethods)) return false;
        return true;
    }
}