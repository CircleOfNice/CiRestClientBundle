<?php

if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
    $contentType = 'Content-Type: ' . $_SERVER['HTTP_CONTENT_TYPE'];
    header($contentType);
}

$httpCode = !isset($_GET['httpCode']) ? 200 : $_GET['httpCode'];
if ($_SERVER['REQUEST_URI'] === '/404') $httpCode = 404;
http_response_code($httpCode);

echo strtolower($_SERVER['REQUEST_METHOD']);