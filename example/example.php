<?php
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

include __DIR__ . '/../vendor/autoload.php';
$c = include __DIR__. '/config.php';

$configProvider = new \Apisearch\ConfigProvider();
$config = $configProvider();

$container = new ServiceManager();
(new Config($config['dependencies']))->configureServiceManager($container);
$container->setService('config', array_merge($config, $c));

/** @var \Apisearch\App\AppRepository $appRepository */
$appRepository = $container->get(\Apisearch\App\AppRepository::class);
if (!$appRepository->checkIndex(\Apisearch\Model\IndexUUID::createById('products'))) {
    $appRepository->createIndex(
        \Apisearch\Model\IndexUUID::createById('products'),
        \Apisearch\Config\Config::createEmpty()
    );

    echo ' - index created!' . PHP_EOL;
} else {
    $appRepository->resetIndex(\Apisearch\Model\IndexUUID::createById('products'));
    echo ' - index reset!' . PHP_EOL;
}

/**
 * @var \Apisearch\Repository\TransformableRepository $repository
 */
$repository = $container->get(\Apisearch\Repository\TransformableRepository::class);
$repository->setRepositoryReference(
    $repository->getRepositoryReference()->changeIndex(\Apisearch\Model\IndexUUID::createById('products'))
);
echo ' - item index started' . PHP_EOL;
$repository->addItem(
    \Apisearch\Model\Item::create(
        \Apisearch\Model\ItemUUID::createByComposedUUID('1~item'),
        ['type' => 'product', 'title' => 'Güral 720916 Exclusive 86 Parça Yemek Takımı'],
        [],
        ['type' => 'product', 'title' => 'Güral 720916 Exclusive 86 Parça Yemek Takımı']
    )
);
$repository->addItem(
    \Apisearch\Model\Item::create(
        \Apisearch\Model\ItemUUID::createByComposedUUID('2~item'),
        ['type' => 'product', 'title' => 'Güral \'720712 86\' Parça Yuvarlak Yemek Takımı'],
        [],
        ['type' => 'product', 'title' => 'Güral \'720712 86\' Parça Yuvarlak Yemek Takımı']
    )
);
$repository->addItem(
    \Apisearch\Model\Item::create(
        \Apisearch\Model\ItemUUID::createByComposedUUID('3~item'),
        ['type' => 'product', 'title' => 'Lexus Yemek Odası'],
        [],
        ['type' => 'product', 'title' => 'Lexus Yemek Odası']
    )
);
$repository->addItem(
    \Apisearch\Model\Item::create(
        \Apisearch\Model\ItemUUID::createByComposedUUID('4~item'),
        ['type' => 'product', 'title' => 'Viola Bebek Odası Takımı'],
        [],
        ['type' => 'product', 'title' => 'Viola Bebek Odası Takımı']
    )
);
$repository->flush();
echo ' - item index ended' . PHP_EOL;
$result = $repository->query(
    \Apisearch\Query\Query::create('yemek takımı')
        ->setMinScore(1)
);

echo ' - Query Ended' . PHP_EOL;
/** @var \Apisearch\Model\Item $item */
foreach ($result->getItems() as $item) {
    echo $item->get('title')  . '['.$item->getScore().']'. PHP_EOL;
}
