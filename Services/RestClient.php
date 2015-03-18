<?php

namespace Ci\CurlBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Ci\CurlBundle\Traits\Exceptions;
use Ci\CurlBundle\Traits\Assertions;

/**
 * Sends curl requests
 *
 * @author    CiGurus <gurus@groups.teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class RestClient implements CrudInterface {
    /**
     * This variable stores the curl instance created through curl initiation
     *
     * @var resource
     */
    private $curl;

    /**
     * Constructor
     *
     * @param  Curl $curl
     * @throws \InvalidArgumentException Curl not installed.
     */
    public function __construct(Curl $curl) {
        $this->curl = $curl;
    }

    /**
     * {@inheritdoc}
     */
    public function get($url, array $options = array()) {
        return $this->curl->sendRequest($url, 'GET', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, $payload, array $options = array()) {
        return $this->curl->sendRequest($url, 'POST', $options, $payload);
    }

    /**
     * {@inheritdoc}
     */
    public function put($url, $payload, array $options = array()) {
        return $this->curl->sendRequest($url, 'PUT', $options, $payload);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($url, array $options = array()) {
        return $this->curl->sendRequest($url, 'DELETE', $options);
    }

    /**
     * sets the content type
     *
     * @param  $contentType
     * @return $this
     */
    public function setContentType($contentType) {
        $this->curl->setContentType($contentType);
        return $this;
    }
}