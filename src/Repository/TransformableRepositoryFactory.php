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
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class TransformableRepositoryFactory
 * @package Apisearch
 */
class TransformableRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : TransformableRepository
    {
        $configuration = $container->get(Configuration::class);
        $config = $container->get('config');
        $configRepository = HttpRepository::class;
        if (isset($config['apisearch']['repository'])) {
            $configRepository = $config['apisearch']['repository'];
        }
        $baseRepository = $container->get($configRepository);
        $repository = new TransformableRepository($baseRepository, new Transformer(new EventDispatcher()));
        $repository->setCredentials(
            RepositoryReferenceBuilder::createFromConfiguration($configuration),
            TokenUUID::createById($configuration->getToken())
        );

        return $repository;
    }
}
