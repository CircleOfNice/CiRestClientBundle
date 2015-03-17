<?php

namespace Ci\CurlBundle\Services;

use Ci\CurlBundle\Traits\Exceptions;

/**
 * Sends curl requests
 *
 * @author    CiGurus <gurus@groups.teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class CurlOptionsHandler {

    use Exceptions;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $defaultOptions;

    /**
     * {@inheritdoc}
     *
     * @param array $defaultOptions
     */
    public function __construct(array $defaultOptions) {
        $this->defaultOptions = $defaultOptions;
        $this->setupOptions();
    }

    /**
     * resets the options to default options
     *
     * @return CurlOptionsHandler
     */
    public function reset() {
        return $this->setupOptions();
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return CurlOptionsHandler
     */
    public function setOption($key, $value) {
        if (!is_string($key)) return $this->invalidArgumentException('key must be string');
        $this->options[constant($key)] = $value;
        return $this;
    }

    /**
     * sets all options for curl execution
     *
     * @param  array $options
     * @return Curl
     */
    public function setOptions(array $options) {
        foreach ($options as $key => $value) $this->setOption($key, $value);
        return $this;
    }

    /**
     * returns all options
     *
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * sets the options array to default values
     *
     * @return CurlOptionsHandler
     */
    private function setupOptions() {
        $this->setOptions($this->defaultOptions);
        return $this;
    }
}