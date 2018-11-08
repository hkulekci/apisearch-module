<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch\App;

use Apisearch\Configuration;
use Apisearch\Model\TokenUUID;
use Apisearch\Repository\RepositoryReferenceBuilder;
use Psr\Container\ContainerInterface;

/**
 * Class InMemoryAppRepositoryFactory
 * @package Apisearch
 */
class InMemoryAppRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : InMemoryAppRepository
    {
        $configuration = $container->get(Configuration::class);
        $repository = new InMemoryAppRepository();

        $repository->setCredentials(
            RepositoryReferenceBuilder::createFromConfiguration($configuration),
            TokenUUID::createById($configuration->getToken())
        );

        return $repository;
    }
}
