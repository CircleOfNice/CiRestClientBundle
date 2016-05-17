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
 * Gets the Response Headers from a Curl Response
 *
 * @author    Timo Linde <info@timo-linde.de>
 * @copyright 2016 TeeAge-Beatz UG
 */
class ResponseHeaders{
    /**
     * {@inheritdoc}
     */
    public static function create($curlResponse, $headerSize) { 
        $header = substr($curlResponse, 0, $headerSize);
        

        return self::httpParseHeaders($header);
    }
    
    /**
     * Parse Http Headers in array
     * 
     * @see https://pecl.php.net/
     * @param string $header
     * @return Array
     */
     public static function httpParseHeaders($header) {
         if (function_exists('http_parse_headers')) {
             return http_parse_headers($header);
         }

         return self::httpParseHeadersPeclReplacement($header);
     }
     
    /**
     * Parse Http Headers in array
     * 
     * @param string $header
     * @return Array
     */
     public static function httpParseHeadersPeclReplacement($header) {
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
        
        if(empty($fields)) {
            
            return array();
        }
        
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