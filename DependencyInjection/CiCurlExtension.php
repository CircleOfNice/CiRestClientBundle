<?php

namespace Ci\CurlBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class CiCurlExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $curlConfigFile   = __DIR__ . '/../Resources/config/curl_config.yml';
        $configs            = array_merge($configs, Yaml::parse(file_get_contents($curlConfigFile)));

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (!isset($config['curl'])) throw new \RuntimeException('configuration ci.curl is missing.');
        if (!isset($config['curl']['defaults'])) throw new \RuntimeException('configuration ci.curl.defaults is missing.');

        $options = array();
        foreach ($config['curl']['defaults'] as $key => $value) {
            $options[constant($key)] = $value;
        };

        $container->setParameter('ci.curl.defaults', $options);
        $container->setParameter('ci.curl.testing_url', $config['curl']['testing_url']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
