<?php

namespace Ci\RestClientBundle\Services;

/**
 * Contract for curl options handler
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
interface CurlOptionsHandlerInterface {

    /**
     * resets the options to default options
     *
     * @return CurlOptionsHandlerInterface
     */
    public function reset();

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return CurlOptionsHandlerInterface
     */
    public function setOption($key, $value);

    /**
     * sets all options for curl execution
     *
     * @param  array $options
     * @return CurlOptionsHandlerInterface
     */
    public function setOptions(array $options);

    /**
     * returns all options
     *
     * @return array
     */
    public function getOptions();
}