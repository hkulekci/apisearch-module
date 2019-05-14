<?php
/**
 * @since     May 2019
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
declare(strict_types=1);

namespace ApisearchTests\Repository;

use Apisearch\Configuration;
use Apisearch\ConfigurationFactory;
use Apisearch\Repository\InMemoryRepositoryFactory;
use ApisearchTests\AbstractTest;
use Interop\Container\Exception\ContainerException;

/**
 * Class InMemoryRepositoryFactoryTest.
 */
class InMemoryRepositoryFactoryTest extends AbstractTest
{
    /**
     * @expectedException
     */
    public function testFactoryWithMissingContainerDependencies(): void
    {
        $this->expectException(ContainerException::class);
        $factory = new InMemoryRepositoryFactory();
        $factory($this->getEmptyContainer());
    }

    /**
     * @expectedException
     */
    public function testFactoryWithContainer(): void
    {
        $factory = new InMemoryRepositoryFactory();
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
