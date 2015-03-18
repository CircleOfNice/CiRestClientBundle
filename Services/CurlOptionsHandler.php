<?php

namespace Ci\CurlBundle\Services;

use Ci\CurlBundle\Traits\Exceptions;

/**
 * Sends curl requests
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
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
        $this->validateOptions($defaultOptions);
        $this->defaultOptions   = $defaultOptions;
        $this->options          = $defaultOptions;
    }

    /**
     * resets the options to default options
     *
     * @return CurlOptionsHandler
     */
    public function reset() {
        $this->options = $this->defaultOptions;
        return $this;
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return CurlOptionsHandler
     */
    public function setOption($key, $value) {
        if (!is_int($key)) return $this->invalidArgumentException('key must be integer');
        $this->options[$key] = $value;
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
     * validates the given options
     *
     * @param  array $options
     * @return $this
     */
    private function validateOptions(array $options) {
        foreach ($options as $key => $value) {
            if (!is_int($key)) $this->invalidArgumentException('Invalid Option given. ' . $key . ' with value ' . $value . ' is not a valid option.');
        }
        return $this;
    }
}