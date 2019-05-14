<?php
/**
 * @since     May 2019
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
declare(strict_types=1);

namespace ApisearchTests\App;

use Apisearch\App\HttpAppRepositoryFactory;
use Apisearch\App\InMemoryAppRepositoryFactory;
use Apisearch\Configuration;
use Apisearch\ConfigurationFactory;
use ApisearchTests\AbstractTest;
use Interop\Container\Exception\ContainerException;

/**
 * Class InMemoryAppRepositoryFactoryTest.
 */
class InMemoryAppRepositoryFactoryTest extends AbstractTest
{
    /**
     * @expectedException
     */
    public function testFactoryWithMissingContainerDependencies(): void
    {
        $this->expectException(ContainerException::class);
        $factory = new InMemoryAppRepositoryFactory();
        $factory($this->getEmptyContainer());
    }

    public function testWithFactoryOptions()
    {

    }

    /**
     * @expectedException
     */
    public function testFactoryWithContainer(): void
    {
        $factory = new HttpAppRepositoryFactory();
        $repository = $factory($this->getContainer(), 'requested-name');

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
