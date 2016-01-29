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

namespace Circle\RestClientBundle\Services;

/**
 * Contract for curl options handler
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
interface CurlOptionsHandlerInterface {

    /**
     * resets the options to default options
     *
     * @return CurlOptionsHandlerInterface
     */
    public function reset();

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return CurlOptionsHandlerInterface
     */
    public function setOption($key, $value);

    /**
     * sets all options for curl execution
     *
     * @param  array $options
     * @return CurlOptionsHandlerInterface
     */
    public function setOptions(array $options);

    /**
     * returns all options
     *
     * @return array
     */
    public function getOptions();
}