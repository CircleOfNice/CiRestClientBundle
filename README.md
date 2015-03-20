CiRestClientBundle
========

#Motivation

There are some Symfony bundles providing functions for REST request, but none of them is actually feeling like: "That's what I was looking for!". In the past we used some of these bundles and we always had to improve or remap their API for our needs. Some days ago the same **it happened again and we started about thinking to hack the bundle again. Call it the CircleOfFrustration. But this time we didn't want to enter the CircleOfFrustration (because we are the CircleOfNice ;)). So we made a decision: Let's think about how a REST client API should look like and afterwards let's implement it by ourselfs.


So how should a REST client API look like? Shouldn't it look like:

```
restclient.post(url, payload);
restclient.get(url);
restclient.put(url, payload);
restclient.delete(url);
```

And what do you expect as a return? Most of the bundles return PHP curl resources. What the hell? You map the PHP internal curl API to another API to make it more comfortable and in the end you get an object with exactly the same API you wanted to get rid of? Why? And what is the improvement? In the end it's easier not to use these bundles and to work with the (extremly uncomfortable) PHP internal curl API.

Ok. We didn't answer the question yet: What should be the outcome? Let's ask some questions:
- You are developing a Symfony bundle, aren't you?
- You are aware of the fundamentals of Symfony, aren't you?
- You know about the Symfony Response Object of the --> HTTP FOUNDATION?
- SO WHY DON'T YOU USE IT AT ALL??

The short story:

There's so much crap in the internet and we want to get rid of it. That's what Circle is supposed to do.

#Description
A smart REST client with a comfortable API providing all REST methods and returning a Symfony Response Object.

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

#Improvements in future
- Strict rules for rest methods such as server MUST NOT return a message-body in the response for HEAD requests
- Improved Exceptions (Instead of curl internal exceptions) extending CurlException
- EventHandling (onRequest, preRequest, postRequest)
