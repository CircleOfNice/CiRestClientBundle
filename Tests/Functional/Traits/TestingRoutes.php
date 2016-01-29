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

/**
 * Provides functions to get Routes and URLs for testing issues
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
trait TestingRoutes {

    /**
     * returns a mock url for testing
     *
     * @param  boolean isHttps
     * @return string
     */
    private function getMockControllerUrl($isHttps = false) {
        $host = 'localhost:8000';
        return $isHttps ? ('https://' . $host) : ('http://' . $host);
    }

    /**
     * creates a route that will return a http status code 200
     *
     * @param  string  $route
     * @param  boolean $isHttps
     * @return string
     */
    private function getHTTP200Route($route = '', $isHttps = false) {
        return $this->getMockControllerUrl($isHttps) . '/' . (empty($route) ? debug_backtrace()[1]['function'] : $route);
    }

    /**
     * creates a route that will return a http status code 404
     *
     * @param  boolean $isHttps
     * @return string
     */
    private function getHTTP404Route($isHttps = false) {
        return $this->getMockControllerUrl($isHttps) . '/404';
    }
}