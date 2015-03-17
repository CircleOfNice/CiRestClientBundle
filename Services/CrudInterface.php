<?php

namespace Ci\CurlBundle\Services;

use Symfony\Component\HttpFoundation\Response;

/**
 * Contract for CRUD methods
 *
 * @author    CiGurus <gurus@groups.teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
interface CrudInterface {
    /**
     * sends a get request to the given url
     *
     * @param  string $url
     * @param  array $additionalOptions
     * @return Response
     */
    public function get($url, array $additionalOptions);

    /**
     * sends a post request to the given url with the given payload
     *
     * @param  string $url
     * @param  string $payload
     * @param  array $additionalOptions
     * @return Response
     */
    public function post($url, $payload, array $additionalOptions);

    /**
     * sends a put request to the given url with the given payload
     *
     * @param  string $url
     * @param  $payload
     * @param  array $additionalOptions
     * @return Response
     */
    public function put($url, $payload, array $additionalOptions);

    /**
     * sends a delete request to the given url
     *
     * @param  string $url
     * @param  array $additionalOptions
     * @return Response
     */
    public function delete($url, array $additionalOptions);
}