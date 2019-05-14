<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch\Repository;

use Apisearch\Configuration;
use Apisearch\Http\CurlAdapter;
use Apisearch\Http\RetryMap;
use Apisearch\Http\TCPClient;
use Apisearch\Model\TokenUUID;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class HttpRepositoryFactory
 * @package Apisearch
 */
class HttpRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): HttpRepository
    {
        /** @var Configuration $configuration */
        /** @var ServiceManager $container */
        $configuration = $options ? $container->build(Configuration::class, $options) : $container->get(Configuration::class);
        $repository = new HttpRepository(
            new TCPClient(
                $configuration->getHost(),
                new CurlAdapter(),
                $configuration->getVersion(),
                new RetryMap()
            )
        );
        $repository->setCredentials(
            RepositoryReferenceBuilder::createFromConfiguration($configuration),
            TokenUUID::createById($configuration->getToken())
        );

        return $repository;
    }
}
