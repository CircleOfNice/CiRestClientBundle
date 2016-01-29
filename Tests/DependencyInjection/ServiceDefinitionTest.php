<?php

namespace Circle\RestClientBundle\Tests\DependencyInjection;
use Circle\RestClientBundle\DependencyInjection\CircleRestClientExtension;
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
     * @var CircleRestClientExtension
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
        $this->extension = new CircleRestClientExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    /**
     * Tests the rest client configuration
     *
     * @test
     *
     * @covers Circle\RestClientBundle\DependencyInjection\CircleRestClientExtension::load
     * @covers Circle\RestClientBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function restClientConfig()
    {
        $this->loadConfiguration($this->container);
        $this->container->compile();

        $this->assertTrue($this->container->has('circle.restclient'));
        $this->assertInstanceOf('Circle\RestClientBundle\Services\RestClient', $this->container->get('circle.restclient'));
    }

    /**
     * Tests the rest client configuration
     *
     * @test
     *
     * @covers Circle\RestClientBundle\DependencyInjection\CircleRestClientExtension::load
     * @covers Circle\RestClientBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function configuration()
    {
        $preConfigs = array(
            'circle_rest_client' => array(
                'curl' => array(
                    'defaults' => array(
                        'CURLOPT_MAXREDIRS'       => 30,
                    )
                )
            )
        );
        $this->loadConfiguration($this->container, $preConfigs);
        $this->container->compile();

        $this->assertTrue($this->container->hasParameter('circle.restclient.curl.defaults'));
        $this->assertSame(
            $preConfigs['circle_rest_client']['curl']['defaults']['CURLOPT_MAXREDIRS'],
            $this->container->getParameter('circle.restclient.curl.defaults')[CURLOPT_MAXREDIRS]
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