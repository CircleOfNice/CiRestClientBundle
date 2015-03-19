<?php

namespace Ci\CurlBundle\Services;

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