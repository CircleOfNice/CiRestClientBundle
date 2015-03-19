<?php

namespace Ci\CurlBundle\Services;

use Ci\CurlBundle\Traits\Exceptions;

/**
 * Sends curl requests
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class CurlOptionsHandler implements CurlOptionsHandlerInterface {

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
     * {@inheritdoc}
     */
    public function reset() {
        $this->options = $this->defaultOptions;
        return $this;
    }

    /**
     * @{@inheritdoc}
     */
    public function setOption($key, $value) {
        $this->validateOptions(array($key => $value));
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options) {
        foreach ($options as $key => $value) $this->setOption($key, $value);
        return $this;
    }

    /**
     * {@inheritdoc}
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
            if (!is_int($key)) return $this->invalidArgumentException('Error while setting a curl option (http://php.net/manual/de/function.curl-setopt.php). Tried to set ' . $key . ' on curl resource.');
        }
        return $this;
    }
}