<?php

namespace Ci\CurlBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Ci\CurlBundle\Traits\Exceptions;
use Ci\CurlBundle\Traits\Assertions;

/**
 * Sends curl requests
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class Curl {

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
        function_exists('curl_version') ? $this->initializeCurl() : $this->curlException("Curl not installed", 2);
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
     * @return $this
     */
    public function setContentType($contentType) {
        return $this->curlOptionsHandler->setOption(CURLOPT_HTTPHEADER, array('Content-Type: ' . $contentType));
    }

    /**
     * Maps the curl response to a Symfony response
     *
     * @param  string $url
     * @param  string $method
     * @param  array $options
     * @param  string $payload
     * @return Response
     */
    public function sendRequest($url, $method, array $options = array(), $payload = '') {
        if (!$this->assertUrl($url))             return $this->invalidArgumentException('Invalid url given: ' . $url);
        if (!$this->assertString($payload))      return $this->invalidArgumentException('Invalid payload given: ' . $payload);
        if (!$this->assertHttpMethod($method))   return $this->invalidArgumentException('Invalid http method given: ' . $method);

        $this->curlOptionsHandler->setOptions($options);

        $curlResponse = $this->preExecute($url, $method, $payload)->execute();

        $curlMetaData = (object) curl_getinfo($this->curl);

        curl_reset($this->curl);
        $this->curlOptionsHandler->reset();

        return $this->createResponse($curlResponse, $curlMetaData);
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
     * builds the environment for curl execution
     *
     * @param  string $url
     * @param  string $method
     * @param  string $payload
     * @param  array $options
     *
     * @return Curl
     */
    private function preExecute($url, $method, $payload) {
        $this->setUrl($url);
        $this->setMethod($method);
        $this->setPayload($payload);
        curl_setopt_array($this->curl, $this->curlOptionsHandler->getOptions());

        return $this;
    }

    /**
     * Maps the curl response to a Symfony response
     *
     * @SuppressWarnings("PHPMD.StaticAccess");
     *
     * @param string    $curlResponse
     * @param \stdClass $curlMetaData
     *
     * @return Response
     */
    private function createResponse($curlResponse, \stdClass $curlMetaData) {
        $response = new Response();
        $response->setContent($curlResponse);
        $response->setStatusCode($curlMetaData->http_code);
        $response->headers->set('Content-Type', $curlMetaData->content_type);

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
        $this->curlOptionsHandler->setOption(CURLOPT_SSL_VERIFYPEER, $this->assertUrlHttps($url));
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
}