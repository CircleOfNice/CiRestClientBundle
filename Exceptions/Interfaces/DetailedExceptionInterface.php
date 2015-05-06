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

namespace Ci\RestClientBundle\Exceptions\Interfaces;

/**
 * Contract for all exceptions that should provide detailed information
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
interface DetailedExceptionInterface {

    /**
     * Returns a human readable and improved error message that explains the exception
     * and why it probably occures.
     *
     * @return string
     */
    public function getDetailedMessage();
}