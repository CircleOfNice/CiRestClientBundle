<?php

namespace Ci\CurlBundle\Services;

use Symfony\Component\HttpFoundation\Response;

/**
 * Sends curl requests
 *
 * @author    CiGurus <gurus@groups.teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class Curl implements CrudInterface {
    /**
     * This variable stores the curl instance created through curl initiation
     *
     * @var resource
     */
    private $curl;

    /**
     * This variable stores a array of curl options
     *
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $defaultOptions = array();

    /**
     * Constructor
     *
     * @param  array $defaultOptions
     * @throws \InvalidArgumentException Curl not installed.
     */
    public function __construct(array $defaultOptions) {
        function_exists('curl_version') ? $this->initializeCurl() : $this->invalidArgumentException("Curl not installed");
        $this->defaultOptions = $defaultOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct() {
        if (is_resource($this->curl)) curl_close($this->curl);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($url, array $additionalOptions = array()) {
        return $this->handleCurl($url, 'GET', $additionalOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, $payload, array $additionalOptions = array()) {
        return $this->handleCurl($url, 'POST', $additionalOptions, $payload);
    }

    /**
     * {@inheritdoc}
     */
    public function put($url, $payload, array $additionalOptions = array()) {
        return $this->handleCurl($url, 'PUT', $additionalOptions, $payload);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($url, array $additionalOptions = array()) {
        return $this->handleCurl($url, 'DELETE', $additionalOptions);
    }

    /**
     * sets the content type
     *
     * @param  $contentType
     * @return $this
     */
    public function setContentType($contentType) {
        return $this->setOption(CURLOPT_HTTPHEADER, array('Content-Type: ' . $contentType));
    }

    /**
     * Maps the curl response to a Symfony response
     *
     * @param  string $url
     * @param  string $method
     * @param  string $payload
     * @param  array $additionalOptions
     * @return Response
     */
    private function handleCurl($url, $method, array $additionalOptions, $payload = '') {
        $curlResponse = $this->preExecute($url, $method, $payload, $additionalOptions)
            ->execute();

        $curlMetaData = (object) curl_getinfo($this->curl);
        curl_reset($this->curl);

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
            return $this->invalidArgumentException("Error: {$error['error']} and the Error no is: {$error['error_no']} ");
        }

        return $curlResponse;
    }

    /**
     * builds the environment for curl execution
     *
     * @param string $url
     * @param string $method
     * @param string $payload
     * @param array $additionalOptions
     *
     * @return Curl
     */
    private function preExecute($url, $method, $payload, array $additionalOptions) {
        $customOptions = $this->options;
        $this->setOptions($this->getDefaultOptions());

        foreach ($customOptions as $option => $value) {
            $this->setOption($option, $value);
        }

        $this->setUrl($url);
        $this->setMethod($method);
        $this->setPayload($payload);
        $this->setOptions($additionalOptions);

        curl_setopt_array($this->curl, $this->options);

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
        $this->setOption(CURLOPT_POSTFIELDS, $payload);
        return $this;
    }

    /**
     * Sets the url on curl object
     *
     * @param  string $url
     * @return Curl
     */
    private function setURL($url) {
        $this->setOption(CURLOPT_URL, $url);
        $this->setOption(CURLOPT_SSL_VERIFYPEER, $this->isUrlHttps($url));
        return $this;
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return Curl
     */
    private function setOption($key, $value) {
        $key = is_string($key) ? constant($key) : $key;
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * sets all options for curl execution
     *
     * @param  array $options
     * @return Curl
     */
    private function setOptions(array $options) {
        foreach ($options as $key => $value) $this->setOption($key, $value);
        return $this;
    }

    /**
     * Sets the method of the curl request
     *
     * @param  string $method
     * @return Curl
     */
    private function setMethod($method) {
        $this->setOption(CURLOPT_CUSTOMREQUEST, strtoupper($method));
        return $this;
    }

    /**
     * initializes the curl object
     *
     * @return Curl
     */
    private function initializeCurl() {
        $this->curl     = curl_init();
        $this->options  = $this->getDefaultOptions();
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
     * returns the default options
     *
     * @return array
     */
    private function getDefaultOptions() {
        $this->defaultOptions[CURLOPT_FOLLOWLOCATION] = isset($this->defaultOptions[CURLOPT_FOLLOWLOCATION]) ? $this->defaultOptions[CURLOPT_FOLLOWLOCATION] : $this->isFollowLocation();
        return $this->defaultOptions;
    }

    /**
     * Validates/Checks the HTTP or HTTPS from given URL
     *
     * @param  string $url
     * @return boolean
     */
    private function isUrlHttps($url) {
        return preg_match('#^https:\/\/#', $url);
    }

    /**
     * Validates/Checks the HTTP or HTTPS from given URL
     *
     * @return boolean
     */
    private function isFollowLocation() {
        return (ini_get('safe_mode') || ini_get('open_basedir')) ? false : true;
    }

    /**
     * throws an invalid argument exception
     *
     * @SuppressWarnings("PHPMD.StaticAccess");
     *
     * @throws \InvalidArgumentException
     * @param  string $message
     * @return Response
     */
    private function invalidArgumentException($message) {
        throw new \InvalidArgumentException($message);
    }
}