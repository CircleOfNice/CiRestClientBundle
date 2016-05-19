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

namespace Circle\RestClientBundle\Types;


/**
 * Gets the Response Headers from a Curl Response
 *
 * @author    Timo Linde <info@timo-linde.de>
 * @copyright 2016 TeeAge-Beatz UG
 */
class ResponseHeaders {
    /**
     * {@inheritdoc}
     * @see https://pecl.php.net/
     */
    public static function create($curlResponse, $headerSize) { 
        $headers = substr($curlResponse, 0, $headerSize);
        
        return function_exists('http_parse_headers') ? http_parse_headers($headers) : self::httpParseHeaders($headers);
    }
    
    /**
     * Parse Http Headers in array
     * 
     * @param string $headers
     * @return Array
     */
     private static function httpParseHeaders($headers) {
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $headers));
        
        if(empty($fields)) return [];
        
        return array_reduce($fields, function($carry, $field) {
            $match = [];
            if (!preg_match('/([^:]+): (.+)/m', $field, $match)) return $carry;

            $match[1] = preg_replace_callback('/(?<=^|[\x09\x20\x2D])./',function($matches) {
                return strtoupper($matches[0]);
            }, strtolower(trim($match[1])));

            $carry[$match[1]] = isset($carry[$match[1]]) ? [$carry[$match[1]], $match[2]] : trim($match[2]);
            
            return $carry;
        }, []);
     }
}