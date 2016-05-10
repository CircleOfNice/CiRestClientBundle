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

use Symfony\Component\HttpFoundation\Response;
use Circle\RestClientBundle\Traits\Exceptions;
use Circle\RestClientBundle\Traits\Assertions;

/**
 * Sends curl requests
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class Curl implements CurlInterface {

    use Exceptions;
    use Assertions;

    /**
     * This variable stores the curl instance created through curl initiation
     *
     * @var resource
     */
    private $curl;

    /**
     * @var CurlOptionsHandler
     */
    private $curlOptionsHandler;

    /**
     * Constructor
     *
     * @param  CurlOptionsHandler $curlOptionsHandler
     * @throws \InvalidArgumentException Curl not installed.
     */
    public function __construct(CurlOptionsHandler $curlOptionsHandler) {
        function_exists('curl_version') ? $this->initializeCurl() : $this->curlException("The PHP curl library is not installed (http://php.net/manual/de/curl.installation.php)", 2);
        $this->curlOptionsHandler = $curlOptionsHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct() {
        if (is_resource($this->curl)) curl_close($this->curl);
        return $this;
    }

    /**
     * sets the content type
     *
     * @param  $contentType
     * @return Curl
     */
    public function setContentType($contentType) {
        $this->curlOptionsHandler->setOption(CURLOPT_HTTPHEADER, array('Content-Type: ' . $contentType));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest($url, $method, array $options = array(), $payload = '') {
        if (!$this->assertUrl($url))             return $this->invalidArgumentException('Invalid url given: ' . $url);
        if (!$this->assertString($payload))      return $this->invalidArgumentException('Invalid payload given: ' . $payload);
        if (!$this->assertHttpMethod($method))   return $this->invalidArgumentException('Invalid http method given: ' . $method);

        $this->curlOptionsHandler->setOptions($options);
        $this->curlOptionsHandler->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->curlOptionsHandler->setOption(CURLOPT_HEADER, true);

        $this->setUrl($url);
        $this->setMethod($method);
        $this->setPayload($payload);
        curl_setopt_array($this->curl, $this->curlOptionsHandler->getOptions());

        $curlResponse = $this->execute();
        $headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
        $headers = substr($curlResponse, 0, $headerSize);
        $content = substr($curlResponse, $headerSize);
        $curlMetaData = (object) curl_getinfo($this->curl);

        $this->curlOptionsHandler->reset();
        function_exists('curl_reset') ? curl_reset($this->curl) : curl_setopt_array($this->curl, $this->curlOptionsHandler->getOptions());

        return $this->createResponse($content, $headers, $curlMetaData);
    }

    /**
     * Executes the curl request
     *
     * @throws \InvalidArgumentException
     * @return Response
     */
    private function execute() {
        $curlResponse = curl_exec($this->curl);

        $error = $this->getError();
        if (!empty($error)) {
            return $this->curlException($error['error'], $error['error_no']);
        }

        return $curlResponse;
    }

    /**
     * Maps the curl response to a Symfony response
     *
     * @SuppressWarnings("PHPMD.StaticAccess");
     *
     * @param string    $content
     * @param string    $headers
     * @param \stdClass $curlMetaData
     *
     * @return Response
     */
    private function createResponse($content, $headers, \stdClass $curlMetaData) {
        $response = new Response();
        $response->setContent($content);
        $response->headers->add(self::httpParseHeaders($headers));
        $response->setStatusCode($curlMetaData->http_code);

        return $response;
    }

    /**
     * sets the payload
     *
     * @param  $payload
     * @return Curl
     */
    private function setPayload($payload) {
        $this->curlOptionsHandler->setOption(CURLOPT_POSTFIELDS, $payload);
        return $this;
    }

    /**
     * Sets the url on curl object
     *
     * @param  string $url
     * @return Curl
     */
    private function setURL($url) {
        $this->curlOptionsHandler->setOption(CURLOPT_URL, $url);
        return $this;
    }

    /**
     * Sets the method of the curl request
     *
     * @param  string $method
     * @return Curl
     */
    private function setMethod($method) {
        $this->curlOptionsHandler->setOption(CURLOPT_CUSTOMREQUEST, strtoupper($method));
        return $this;
    }

    /**
     * initializes the curl object
     *
     * @return Curl
     */
    private function initializeCurl() {
        $this->curl = curl_init();
        return $this;
    }

    /**
     * Returns the errors
     *
     * @return array
     */
    private function getError() {
        if (!curl_errno($this->curl)) return array();
        return array('error_no' => curl_errno($this->curl), 'error' => curl_error($this->curl));
    }
    
    /**
     * Parse Http Headers in array
     * 
     * @param string $header
     * @return Array
     */
     public static function httpParseHeaders($header) {
         if (function_exists('http_parse_headers')) return http_parse_headers($header);

         $retVal = array();
         $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
         foreach ($fields as $field) {
             $match = array();
             if (preg_match('/([^:]+): (.+)/m', $field, $match)) {
                 $match[1] = preg_replace_callback('/(?<=^|[\x09\x20\x2D])./',function($matches) {
                        return strtoupper($matches[0]);
                    }
                    , strtolower(trim($match[1])));
                 if (isset($retVal[$match[1]])) {
                     $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
                 } else {
                     $retVal[$match[1]] = trim($match[2]);
                 }
             }
         }
         
         return $retVal;
     }
}