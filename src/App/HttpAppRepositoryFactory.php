<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch\App;

use Apisearch\Configuration;
use Apisearch\Http\GuzzleClient;
use Apisearch\Http\RetryMap;
use Apisearch\Model\TokenUUID;
use Apisearch\Repository\RepositoryReferenceBuilder;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

/**
 * Class HttpAppRepositoryFactory
 * @package Apisearch
 */
class HttpAppRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : HttpAppRepository
    {
        $configuration = $container->get(Configuration::class);
        $guzzleClient = new Client([
            'host' => $configuration->getHost(),
        ]);
        $repository = new HttpAppRepository(
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
