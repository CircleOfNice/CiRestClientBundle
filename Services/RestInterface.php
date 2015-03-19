<?php

namespace Ci\RestClientBundle\Services;

use Symfony\Component\HttpFoundation\Response;

/**
 * Contract for CRUD methods
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
interface RestInterface {
    /**
     * sends a get request to the given url
     *
     * @param  string $url
     * @param  array  $additionalOptions
     * @return Response
     */
    public function get($url, array $additionalOptions);

    /**
     * sends a post request to the given url with the given payload
     *
     * @param  string $url
     * @param  string $payload
     * @param  array  $additionalOptions
     * @return Response
     */
    public function post($url, $payload, array $additionalOptions);

    /**
     * sends a put request to the given url with the given payload
     *
     * @param  string $url
     * @param  string $payload
     * @param  array  $additionalOptions
     * @return Response
     */
    public function put($url, $payload, array $additionalOptions);

    /**
     * sends a delete request to the given url
     *
     * @param  string $url
     * @param  array  $additionalOptions
     * @return Response
     */
    public function delete($url, array $additionalOptions);

    /**
     * sends a head request to the given url
     *
     * @param  string $url
     * @param  array  $additionalOptions
     * @return Response
     */
    public function head($url, array $additionalOptions);

    /**
     * sends an options request to the given url
     *
     * @param  string $url
     * @param  string $payload
     * @param  array  $additionalOptions
     * @return Response
     */
    public function options($url, $payload, array $additionalOptions);

    /**
     * sends a trace request to the given url
     *
     * @param  string $url
     * @param  array  $additionalOptions
     * @return Response
     */
    public function trace($url, array $additionalOptions);

    /**
     * sends a head request to the given url
     *
     * @param  string $url
     * @param  array  $additionalOptions
     * @return Response
     */
    public function connect($url, array $additionalOptions);

    /**
     * sends a patch request to the given url
     *
     * @param  string $url
     * @param  string $payload
     * @param  array  $additionalOptions
     * @return Response
     */
    public function patch($url, $payload, array $additionalOptions);
}