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

/**
 * This file provides the test server for functional tests
 */

if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
    $contentType = 'Content-Type: ' . $_SERVER['HTTP_CONTENT_TYPE'];
    header($contentType);
}

$httpCode = !isset($_GET['httpCode']) ? 200 : $_GET['httpCode'];
if ($_SERVER['REQUEST_URI'] === '/404') $httpCode = 404;
http_response_code($httpCode);

echo strtolower($_SERVER['REQUEST_METHOD']);