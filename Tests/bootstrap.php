<?php

/**
 * @author    tobias.hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */

$file = __DIR__.'/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}
$autoload = require_once $file;
