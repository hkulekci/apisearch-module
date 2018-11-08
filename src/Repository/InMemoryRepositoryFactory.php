<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch\Repository;

use Apisearch\Configuration;
use Apisearch\Model\TokenUUID;
use Psr\Container\ContainerInterface;

/**
 * Class InMemoryRepositoryFactory
 * @package Apisearch
 */
class InMemoryRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : InMemoryRepository
    {
        $configuration = $container->get(Configuration::class);
        $repository = new InMemoryRepository();

        $repository->setCredentials(
            RepositoryReferenceBuilder::createFromConfiguration($configuration),
            TokenUUID::createById($configuration->getToken())
        );

        return $repository;
    }
}
