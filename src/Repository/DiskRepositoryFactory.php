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
 * Class DiskRepositoryFactory
 * @package Apisearch
 */
class DiskRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : DiskRepository
    {
        $configuration = $container->get(Configuration::class);
        $config = $container->get('config');
        if (!isset($config['apisearch']['diskRepository']['filename'])) {
            throw new \RuntimeException('Please provide a file name in your configuration to use disk repository');
        }
        $repository = new DiskRepository($config['apisearch']['diskRepository']['filename']);

        $repository->setCredentials(
            RepositoryReferenceBuilder::createFromConfiguration($configuration),
            TokenUUID::createById($configuration->getToken())
        );

        return $repository;
    }
}
