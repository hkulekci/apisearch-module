# Apisearch Zend Framework Module

Apisearch is an open source search engine fully based on open source 
third party technologies. The project provides an in crescendo set of 
language integration libraries for her users, as well as some third 
party projects integration bundles, modules, plugins, or javascript 
widgets.

This module is a library to easily integrate with Zend Framework and 
Zend Expressive. Here how you can install the library:

```
composer require hkulekci/apisearch-module
```

After installing the module with composer, you need to define some 
configuration for the Apisearch. You can create a `apisearch.local.php` 
file into your `config/autoload` folder with following structure:

```
<?php

return [
    'apisearch' => [
        'host'  => '---your-api-search-server-host---',
        'version' => 'v1',
        'repository' => \Apisearch\Repository\HttpRepository::class,
        'token' => '---your-secret-app-token---',
        'appId' => '---your-app-id---',
    ]
];
```

Then you can use the container to reach the Apisearch Client instance 
like below: 

```
class ProductFactory
{
    public function __invoke($container)
    {
        return new Product(
            $container->get(\Apisearch\Repository\TransformableRepository::class)
        );
    }
}

class ProductSearchFactory
{
    public function __invoke($container)
    {
        return new ProductSearch(
            $container->get(\Apisearch\Repository\TransformableRepository::class)
        );
    }
}

class Product
{
    protected repository;
    
    public function __constructor($repository)
    {
        $this->repository = $repository;
    }
    
    public function indexItem(array $item)
    {
        $id = $item['id'];
        // do some logic 
        $this->repository->addItem(
            \Apisearch\Model\Item::create(
                \Apisearch\Model\ItemUUID::createByComposedUUID($id),
                $item,
                [],
                $item
            )
        );
    }
}

class ProductSearch
{
    protected $repository;
    
    public function __constructor($repository)
    {
        $this->repository = $repository;
    }
    
    public function doSearch($keyword)
    {
        return $this->repository->query(
            \Apisearch\Query\Query::create($keyword)
                ->setMinScore(1)
        );
    }
}
```

You can see the dependencies in the config provider what we have in the container for 
Apisearch.

```
    Apisearch\Configuration::class                       => Apisearch\ConfigurationFactory::class,
    Apisearch\App\AppRepository::class                   => Apisearch\App\HttpAppRepositoryFactory::class,
    Apisearch\Repository\HttpRepository::class           => Apisearch\Repository\HttpRepositoryFactory::class,
    Apisearch\Repository\TransformableRepository::class  => Apisearch\Repository\TransformableRepositoryFactory::class,
    Apisearch\Repository\InMemoryRepository::class       => Apisearch\Repository\InMemoryRepositoryFactory::class, // For testing
``` 

For more information please check the [documentation](http://docs.apisearch.io/).
Also check the `example/example.php` file for full example usage.
