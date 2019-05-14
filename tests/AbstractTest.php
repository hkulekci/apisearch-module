<?php
/**
 * AbstractTest
 *
 * @since     May 2019
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace ApisearchTests;

use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

abstract class AbstractTest extends TestCase
{
    abstract protected function getContainerDependencies(): array;

    public function getEmptyContainer(): ServiceManager
    {
        return new ServiceManager();
    }

    public function getContainer(): ContainerInterface
    {
        // Build container
        $container = new ServiceManager();
        (new Config($this->getContainerDependencies()))->configureServiceManager($container);

        // Inject config
        $container->setService('config', $this->getContainerConfig());

        return $container;
    }

    protected function getContainerConfig(): array
    {
        return [
            'apisearch' => [
                'host'  => 'http://localhost:8100/',
                'version' => 'v1',
                'repository' => \Apisearch\Repository\HttpRepository::class,
                'token' => '123456-123456-12333-12333-1233',
                'appId' => 'products-app',
                'diskRepository' => [
                    'filename' => 'data/file.data',
                ],
            ]
        ];
    }
}
