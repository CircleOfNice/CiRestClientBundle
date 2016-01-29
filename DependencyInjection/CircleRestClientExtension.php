<?php
/**
 * This file is part of CircleRestClientBundle.
 *
 * CircleRestClientBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CircleRestClientBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CircleRestClientBundle.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Circle\RestClientBundle\DependencyInjection;

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
class CircleRestClientExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $curlConfigFile   = __DIR__ . '/../Resources/config/curl_config.yml';
        $configs          = array_merge(Yaml::parse(file_get_contents($curlConfigFile)), $configs);
        if (!isset($configs['circle_rest_client'])) throw new \RuntimeException('configuration circle_rest_client is missing.');

        $configuration  = new Configuration();
        $config         = $this->processConfiguration($configuration, $configs);

        if (!isset($config['curl'])) throw new \RuntimeException('configuration circle_rest_client.curl is missing.');
        if (!isset($config['curl']['defaults'])) throw new \RuntimeException('configuration circle_rest_client.curl.defaults is missing.');

        $options = array();
        foreach ($config['curl']['defaults'] as $key => $value) {
            $options[constant($key)] = $value;
        };

        $container->setParameter('circle.restclient.curl.defaults', $options);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
