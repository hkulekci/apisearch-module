<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Apisearch;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ConfigurationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : Configuration
    {
        if ($options) {
            return Configuration::createFromArray($options);
        }

        $config = $container->get('config');
        if (!isset($config['apisearch'])) {
            throw new \RuntimeException('Please provide a apisearch configuration.');
        }

        return Configuration::createFromArray($config['apisearch']);
    }
}
