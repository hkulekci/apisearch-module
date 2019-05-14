<?php
/**
 * @since     May 2019
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
declare(strict_types=1);

namespace ApisearchTests;

use Apisearch\Configuration;
use Apisearch\ConfigurationFactory;
use Interop\Container\Exception\ContainerException;

/**
 * Class ConfigurationFactoryTest.
 */
class ConfigurationFactoryTest extends AbstractTest
{
    /**
     * @expectedException
     */
    public function testFactoryWithMissingContainerDependencies(): void
    {
        $this->expectException(ContainerException::class);
        $factory = new ConfigurationFactory();
        $factory($this->getEmptyContainer(), 'requested-name');
    }

    /**
     * @expectedException
     */
    public function testFactoryWithMissingConfiguration(): void
    {
        $this->expectException(\RuntimeException::class);
        $container = $this->getEmptyContainer();
        $container->setService('config', []);
        $factory = new ConfigurationFactory();
        $factory($container, 'requested-name');
    }

    /**
     * @expectedException
     */
    public function testFactoryWithContainer(): void
    {
        $factory = new ConfigurationFactory();
        $configuration = $factory($this->getContainer(), 'requested-name');

        $this->assertEquals('123456-123456-12333-12333-1233', $configuration->getToken());
        $this->assertEquals('v1', $configuration->getVersion());
        $this->assertEquals('products-app', $configuration->getAppId());
        $this->assertEquals('http://localhost:8100/', $configuration->getHost());
    }

    protected function getContainerDependencies(): array
    {
        return [
            'factories' => [
                Configuration::class => ConfigurationFactory::class,
            ],
        ];
    }
}
