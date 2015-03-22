<?php

namespace Ci\RestClientBundle\Tests\DependencyInjection;
use Ci\RestClientBundle\DependencyInjection\CiRestClientExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Test for the service definitions
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class ServiceDefinitionTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var CiRestClientExtension
     */
    private $extension;

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->extension = new CiRestClientExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    /**
     * Tests the rest client configuration
     *
     * @test
     *
     * @covers Ci\RestClientBundle\DependencyInjection\CiRestClientExtension::load
     * @covers Ci\RestClientBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function restClientConfig()
    {
        $this->loadConfiguration($this->container);
        $this->container->compile();

        $this->assertTrue($this->container->has('ci.restclient'));
        $this->assertInstanceOf('Ci\RestClientBundle\Services\RestClient', $this->container->get('ci.restclient'));
    }

    /**
     * Tests the rest client configuration
     *
     * @test
     *
     * @covers Ci\RestClientBundle\DependencyInjection\CiRestClientExtension::load
     * @covers Ci\RestClientBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function configuration()
    {
        $preConfigs = array(
            'ci_rest_client' => array(
                'curl' => array(
                    'defaults' => array(
                        'CURLOPT_MAXREDIRS'       => 30,
                    )
                )
            )
        );
        $this->loadConfiguration($this->container, $preConfigs);
        $this->container->compile();

        $this->assertTrue($this->container->hasParameter('ci.restclient.curl.defaults'));
        $this->assertSame(
            $preConfigs['ci_rest_client']['curl']['defaults']['CURLOPT_MAXREDIRS'],
            $this->container->getParameter('ci.restclient.curl.defaults')[CURLOPT_MAXREDIRS]
        );
    }

    /**
     * Loads the configuration of the extension
     *
     * @param  ContainerBuilder $container
     * @param  array            $existingConfigs
     * @return void
     */
    private function loadConfiguration(ContainerBuilder $container, array $existingConfigs = array())
    {
        $this->extension->load($existingConfigs, $container);
    }
}