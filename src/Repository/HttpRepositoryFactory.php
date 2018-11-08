<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch\Repository;

use Apisearch\Configuration;
use Apisearch\Http\GuzzleClient;
use Apisearch\Http\RetryMap;
use Apisearch\Model\TokenUUID;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

/**
 * Class HttpRepositoryFactory
 * @package Apisearch
 */
class HttpRepositoryFactory
{
    public function __invoke(ContainerInterface $container): HttpRepository
    {
        $configuration = $container->get(Configuration::class);
        $guzzleClient = new Client([
            'host' => $configuration->getHost(),
        ]);
        $repository = new HttpRepository(
            new GuzzleClient(
                $guzzleClient,
                $configuration->getHost(),
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
