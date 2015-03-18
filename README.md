CurlBundle
========

This bundle provides a rest client and sends (curl)requests to a given url and maps the response to a symfony response object.

#Installation

##Step 1: Download the bundle using composer
Add the bundle by running the command:
```
php composer.phar require ci/curlbundle
```
Composer will install the bundle to your project's ```vendor/ci``` directory.

##Step 2: Enable the bundle
Enable the bundle in the symfony kernel

```php
<?php
// PROJECTROOT/app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Ci\CurlBundle\CiCurlBundle(),
    );
}
```

#Configuration

The bundle allows you to configure all default options that the underlying PHP internal curl library provides - with their real names.
You can change the configuration by adding the following lines to your app/config.yml:

```
ci:
  curl:
    defaults:
      $optionName: $value
      $optionName: $value
      ...
```

##Example:

```
ci:
  curl:
    defaults:
      CURLOPT_RETURNTRANSFER: true
      CURLOPT_HTTPHEADER:     [ 'Content-Type: text/plain' ]
      CURLOPT_MAXREDIRS:      25
      CURLOPT_TIMEOUT:        25
      CURLOPT_CONNECTTIMEOUT: 25
      CURLOPT_CRLF:           true
      CURLOPT_SSLVERSION:     3
      CURLOPT_FOLLOWLOCATION: true
```

#Usage

```
$restClient = $this->container->get('ci.restclient');

$restClient->get('http://www.someUrl.com');
$restClient->post('http://www.someUrl.com', 'somePayload');
$restClient->put('http://www.someUrl.com', 'somePayload');
$restClient->delete('http://www.someUrl.com');
$restClient->patch('http://www.someUrl.com', 'somePayload');

$restClient->head('http://www.someUrl.com');
$restClient->options('http://www.someUrl.com', 'somePayload');
$restClient->trace('http://www.someUrl.com');
$restClient->connect('http://www.someUrl.com');
```

##AdvancedUsage

You can add additional options to customize a specific request by adding an option array as key value store.

```
$restClient = $this->container->get('ci.restclient');

$restClient->get('http://www.someUrl.com', array(CURLOPT_CONNECTTIMEOUT => 30));
$restClient->post('http://www.someUrl.com', 'somePayload', array(CURLOPT_CONNECTTIMEOUT => 30));
$restClient->put('http://www.someUrl.com', 'somePayload', array(CURLOPT_CONNECTTIMEOUT => 30));
$restClient->delete('http://www.someUrl.com', array(CURLOPT_CONNECTTIMEOUT => 30));

$restClient->head('http://www.someUrl.com', array(CURLOPT_CONNECTTIMEOUT => 30));
$restClient->options('http://www.someUrl.com', 'somePayload', array(CURLOPT_CONNECTTIMEOUT => 30));
$restClient->trace('http://www.someUrl.com', array(CURLOPT_CONNECTTIMEOUT => 30));
$restClient->connect('http://www.someUrl.com', array(CURLOPT_CONNECTTIMEOUT => 30));
```

#Improvements in future
- EventHandling (onCurlRequest, preCurlRequest, postCurlRequest)
- Improved Exceptions (Instead of curl internal exceptions) extending CurlException
- Strict rules for rest methods such as server MUST NOT return a message-body in the response for HEAD requests
