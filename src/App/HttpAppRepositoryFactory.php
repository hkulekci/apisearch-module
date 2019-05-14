<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch\App;

use Apisearch\Configuration;
use Apisearch\Http\CurlAdapter;
use Apisearch\Http\TCPClient;
use Apisearch\Http\RetryMap;
use Apisearch\Model\TokenUUID;
use Apisearch\Repository\RepositoryReferenceBuilder;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class HttpAppRepositoryFactory
 * @package Apisearch
 */
class HttpAppRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : HttpAppRepository
    {
        /** @var Configuration $configuration */
        /** @var ServiceManager $container */
        $configuration = $options ? $container->build(Configuration::class, $options) : $container->get(Configuration::class);
        $repository = new HttpAppRepository(
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
