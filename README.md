CiRestClientBundle
========

A Smart REST client with an intuitive API, providing all REST methods and returning a Symfony Response Object.

#Motivation

There are some Symfony2 bundles providing abstractions for REST requests, but none of them is actually feeling like: "That's what I was looking for!". Having used some of these in the past, we always had to improve or remap their API's for our own needs.

Some days ago we faced the same frustrating challenge again and started to meditate about the idea that our specific API needs really aren't that particular. So we questioned ourselves how a simple REST-Client-API should look like:

```
$restclient->post($url, $payload);
$restclient->get($url);
$restclient->put($url, $payload);
$restclient->delete($url);
```

Another concern was the leaky abstraction many of the other bundles present to us in respect to the output: They map the PHP-native curl-addon's API to an object-oriented interface only to let us work with the non-object-oriented original output of curl's API calls. At this point it is more convenient to stay with the (extremely inconvenient) PHP internal curl API only. 

But how should outputs be wrapped? 
* So by visiting this page you are probably a Symfony developer
* Thus we can infer that you know about the Symfony Response Object

So the Symfony Response Object is our choice to go: We don't need to roll out our own implementation and can stay within the boundaries of our framework of choice - win/win :-).

So all in all let's call it a day and start goin' gorillas with this one.

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

The bundle allows you to configure all default options that the underlying PHP internal curl library provides - with their real names. No re-re-re-mapping-mapping-re-... :D

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
- Vendors must be installed via composer
- (Of course) Phpunit must be installed
- Port 8000 must not be blocked on the local machine
- XDebug should be enabled

##Executing tests
The Tests are executed against a local php server located in the Tests/TestServer folder. Execute the tests via
```
make test
```

#Roadmap
- Strict rules for rest methods such as server MUST NOT return a message-body in the response for HEAD requests
- Improved Exceptions (Instead of curl internal exceptions) extending CurlException
- EventHandling (onRequest, preRequest, postRequest)
