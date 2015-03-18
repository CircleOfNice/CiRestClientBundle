CurlBundle
========

This bundle provides a rest client and sends (curl)requests to a given url and maps the response to a symfony response object.

#Installation

###Step 1: Download CiUtilityBundle using composer
Add CiUtilityBundle by running the command:
```
php composer.phar require ci/utilitybundle
```
Composer will install the bundle to your project's ```vendor/ci``` directory.

###Step 2: Enable the bundle
Enable the bundle in the symfony kernel

```php
<?php
// PROJECTROOT/app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Ci\UtilityBundle\CiUtilityBundle(),
    );
}
```
