# Apisearch Zend Framework Module

You can install it like below.

```
composer require hkulekci/apisearch-module
```

Then you need to set some configuration. You can create a `apisearch.local.php` file into your `config/autoload` folder.

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

Then please check the example folder of the project.
