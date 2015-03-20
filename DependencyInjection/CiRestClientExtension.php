<?php
/**
 * This file is part of CiRestClientBundle.
 *
 * CiRestClientBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CiRestClientBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CiRestClientBundle.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Ci\RestClientBundle\DependencyInjection;

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
class CiRestClientExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $curlConfigFile   = __DIR__ . '/../Resources/config/curl_config.yml';
        $configs          = array_merge($configs, Yaml::parse(file_get_contents($curlConfigFile)));

        $configuration  = new Configuration();
        $config         = $this->processConfiguration($configuration, $configs);

        if (!isset($config['restclient'])) throw new \RuntimeException('configuration ci.restclient is missing.');
        if (!isset($config['restclient']['curl'])) throw new \RuntimeException('configuration ci.restclient.curl is missing.');
        if (!isset($config['restclient']['curl']['defaults'])) throw new \RuntimeException('configuration ci.restclient.curl.defaults is missing.');

        $options = array();
        foreach ($config['restclient']['curl']['defaults'] as $key => $value) {
            $options[constant($key)] = $value;
        };

        $container->setParameter('ci.restclient.curl.defaults', $options);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
