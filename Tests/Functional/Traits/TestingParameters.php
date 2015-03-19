<?php

namespace Ci\CurlBundle\Tests\Functional\Traits;

/**
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
trait TestingParameters {

    /**
     * returns a mock url for testing
     *
     * @return string
     */
    private function getMockControllerUrl() {
        return 'http://localhost:8888';
    }
}