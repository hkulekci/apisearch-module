<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch;

use Psr\Container\ContainerInterface;

class ConfigurationFactory
{
    public function __invoke(ContainerInterface $container) : Configuration
    {
        $config = $container->get('config');
        if (!isset($config['apisearch'])) {
            throw new \RuntimeException('Please provide a apisearch configuration.');
        }
        return Configuration::createFromArray($config['apisearch']);
    }
}
