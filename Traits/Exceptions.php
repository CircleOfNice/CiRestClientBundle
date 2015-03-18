<?php

namespace Ci\CurlBundle\Traits;

use Ci\CurlBundle\Exceptions\CurlException;

/**
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
trait Exceptions {

    /**
     * throws a curl exception
     *
     * @param  string $message
     * @param  int    $code
     * @throws CurlException
     */
    private function curlException($message, $code) {
        throw new CurlException("Error: {$message} and the Error no is: {$code} ", $code);
    }

    /**
     * throws an invalid argument exception
     *
     * @param  $message
     * @throws \InvalidArgumentException
     */
    private function invalidArgumentException($message) {
        throw new \InvalidArgumentException($message);
    }
}