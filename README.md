CiRestClientBundle
========

There are some Symfony bundles providing functions for REST request, but none of them is actually doing what it is supposed to do or it has a non-intuitive API.
The default usecases for sending requests to another endpoint are so simple that we are wondering why there are so many bad solutions for this use case.
Imagine you just want to send a GET request to another endpoint. What do you think the API should look like? Shouldn't it look like:
```
restclient.get(url);
```

Or imagine you want to send a POST request. What do you really want to do?
```
restclient.post(url);
```

And what do you expect as a return? Shouldn't it be a simple Symfony Response Object?

This bundle provides an intuitive API for sending REST requests and returns a Symfony Object.
It works as you'd expect. If it's not: Let us know!

#Installation

##Step 1: Download the bundle using composer
Add the bundle by running the command:
```
php composer.phar require ci/restclientbundle
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
        new Ci\RestClientBundle\CiRestClientBundle(),
    );
}
```

#Configuration

The bundle allows you to configure all default options that the underlying PHP internal curl library provides - with their real names.

The names and their possible values can be found here: http://php.net/manual/de/function.curl-setopt.php

You can change the configuration by adding the following lines to your app/config.yml:

```
ci:
  restclient:
    curl:
      defaults:
        $optionName: $value
        $optionName: $value
        ...
```

##Example:

```
ci:
  restclient:
    curl:
      defaults:
        CURLOPT_HTTPHEADER:     [ 'Content-Type: application/json' ]
        CURLOPT_FOLLOWLOCATION: true
```

Sets thre request header to application/json and follows redirects.

##Exceptions:
You cannot change the default value for CURLOPT_RETURNTRANSFER (default=true).

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

#Testing the bundle

The bundle can be tested via phpunit.

##Preconditions
- NodeJs must be installed
- Vendors must be installed via composer
- (Of course) Phpunit must be installed
- Port 8888 must not be blocked on the local machine
- XDebug should be enabled

##Executing tests
The Tests are executed against a local node server. That means first of all you have to start the node server.
```
node nodeServer.js
```

Then the tests can be executed via:

```
phpunit -c phpunit.xml
```

#Improvements in future
- Strict rules for rest methods such as server MUST NOT return a message-body in the response for HEAD requests
- Improved Exceptions (Instead of curl internal exceptions) extending CurlException
- EventHandling (onRequest, preRequest, postRequest)
