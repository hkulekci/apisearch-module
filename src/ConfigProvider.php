<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch;

use Apisearch\App\AppRepository;
use Apisearch\App\HttpAppRepositoryFactory;
use Apisearch\Repository\HttpRepository;
use Apisearch\Repository\HttpRepositoryFactory;
use Apisearch\Repository\InMemoryRepository;
use Apisearch\Repository\InMemoryRepositoryFactory;
use Apisearch\Repository\TransformableRepository;
use Apisearch\Repository\TransformableRepositoryFactory;

class ConfigProvider
{
    /**
     * Return the configuration array.
     */
    public function __invoke() : array
    {
        return [
            'dependencies'  => $this->getDependencies(),
            'apisearch'     => $this->defaultConfiguration(),
        ];
    }

    private function defaultConfiguration() : array
    {
        return [
            'host'  => 'http://127.0.0.1:8200/',
            'version' => 'v1',
            'repository' => HttpRepository::class,
            'token' => '',
            'appId' => '',
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories' => [
                Configuration::class            => ConfigurationFactory::class,
                AppRepository::class            => HttpAppRepositoryFactory::class,
                HttpRepository::class           => HttpRepositoryFactory::class,
                TransformableRepository::class  => TransformableRepositoryFactory::class,
                InMemoryRepository::class       => InMemoryRepositoryFactory::class,
            ],
        ];
    }
}
