<?php

namespace Ci\CurlBundle\Traits;

/**
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
            'GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS', 'TRACE', 'CONNECT', 'PATCH'
        );
        if (!in_array($method, $validHttpMethods)) return false;
        return true;
    }

    /**
     * Validates/Checks the HTTP or HTTPS from given URL
     *
     * @param  string $url
     * @return $this
     */
    private function assertUrlHttps($url) {
        return preg_match('#^https:\/\/#', $url) && $this->assertUrl($url);
    }
}