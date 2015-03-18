<?php

namespace Ci\CurlBundle\Services;

/**
 * Sends curl requests
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class RestClient implements RestInterface {
    /**
     * This variable stores the curl instance created through curl initiation
     *
     * @var Curl
     */
    private $curl;

    /**
     * Constructor
     *
     * @param  Curl $curl
     * @throws \Ci\CurlBundle\Exceptions\CurlException (Curl not installed.)
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
     * {@inheritdoc}
     */
    public function head($url, array $options = array()) {
        return $this->curl->sendRequest($url, 'HEAD', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function options($url, $payload, array $options = array()) {
        return $this->curl->sendRequest($url, 'OPTIONS', $options, $payload);
    }

    /**
     * {@inheritdoc}
     */
    public function trace($url, array $options = array()) {
        return $this->curl->sendRequest($url, 'TRACE', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function connect($url, array $options = array()) {
        return $this->curl->sendRequest($url, 'CONNECT', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($url, $payload, array $options = array()) {
        return $this->curl->sendRequest($url, 'PATCH', $options, $payload);
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