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

namespace Ci\RestClientBundle\Services;

/**
 * Provides methods for curl handling
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
interface CurlInterface {

    /**
     * Maps the curl response to a Symfony response
     *
     * @param  string $url
     * @param  string $method
     * @param  array $options
     * @param  string $payload
     * @return Response
     */
    public function sendRequest($url, $method, array $options = array(), $payload = '');
}