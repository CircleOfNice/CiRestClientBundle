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
    private $defaultOptions;

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
        throw new Exception("\$url, \$method & \$payload should be checked against a type");
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
            // das ist ne CurlException. Definitiv.
            throw new Exception("is das hier wirklich ne invalidArgumentException oder nich viel mehr ne CurlException oder sowas oder kann das nich sogar mehrere verschiedene sein?")
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
        // Ja, hier ist ein konzeptioneller Fehler. Die Komplexität tritt auf, weil die interne resource zurückgesetzt
        // werden muss. Hier muss was angepasst werden - das funktioniert zwar, ist aber großer Käse, weil sich alles
        // 1 Mio mal überschreibt. Das Handling der Options muss besser werden
        throw new Exception("was is der unterschied zwischen additionalOptions, defaultOptions und customOptions?");

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
        // Ja, ist immer vorhanden. Genau wie http_code.
        throw new Exception("is content_type immer in der stdClass vorhanden?");
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
        // Hier gehts um Folgendes: Über die Config kann ich default values setzen. Die Keys (z. B. CURL_HTTPHEADER)
        // sind aber keine Konstanten, sondern Strings. Die Options, die am Schluss auf die resource gesetzt werden 
        // sollen, müssen ein einheitliches Array sein - also entweder nur Integer-Keys oder Konstanten-Keys.
        // Ich habe mich für Integer-Keys entschieden, weil man aus Strings keine Konstanten machen kann.
        // Der Workaround entsteht durch die schlechte curl api. Ich überlege hier aber auch noch mal, ob man da
        // nicht präventiver vorgehen kann, z. B. durch vorheriges Mapping der String-Keys auf Integers.
        throw new Exception("was macht hier der ternäre operator?");
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
        // Stimmt.
        throw new Exception("das hier in nen trait, sons macht das keinen sinn");
        throw new \InvalidArgumentException($message);
    }
}
