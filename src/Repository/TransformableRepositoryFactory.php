<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch\Repository;

use Apisearch\Configuration;
use Apisearch\Model\TokenUUID;
use Apisearch\Transformer\Transformer;
use Interop\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class TransformableRepositoryFactory
 * @package Apisearch
 */
class TransformableRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : TransformableRepository
    {
        /** @var Configuration $configuration */
        /** @var ServiceManager $container */
        $configuration = $container->get(Configuration::class);
        $config = $container->get('config');
        $configRepository = $config['apisearch']['repository'] ?? HttpRepository::class;
        $baseRepository = $options ? $container->build($configRepository, $options) : $container->get($configRepository);
        $repository = new TransformableRepository($baseRepository, new Transformer(new EventDispatcher()));
        $repository->setCredentials(
            RepositoryReferenceBuilder::createFromConfiguration($configuration),
            TokenUUID::createById($configuration->getToken())
        );

        return $repository;
    }
}
