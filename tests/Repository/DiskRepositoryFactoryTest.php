<?php
/**
 * @since     May 2019
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
declare(strict_types=1);

namespace ApisearchTests\Repository;

use Apisearch\Configuration;
use Apisearch\ConfigurationFactory;
use Apisearch\Repository\DiskRepositoryFactory;
use ApisearchTests\AbstractTest;
use Interop\Container\Exception\ContainerException;

/**
 * Class DiskRepositoryFactoryTest.
 */
class DiskRepositoryFactoryTest extends AbstractTest
{
    /**
     * @expectedException
     */
    public function testFactoryWithMissingContainerDependencies(): void
    {
        $this->expectException(ContainerException::class);
        $factory = new DiskRepositoryFactory();
        $factory($this->getEmptyContainer());
    }

    /**
     * @expectedException
     */
    public function testFactoryWithContainer(): void
    {
        $factory = new DiskRepositoryFactory();
        $repository = $factory($this->getContainer());

        $this->assertEquals('123456-123456-12333-12333-1233', $repository->getTokenUUID()->composeUUID());
        $this->assertNull($repository->getIndexUUID());
        $this->assertEquals('products-app', $repository->getAppUUID()->composeUUID());
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
