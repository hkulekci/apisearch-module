<?php
namespace Apisearch\Repository;

use Apisearch\Configuration;
use Apisearch\Model\AppUUID;
use Apisearch\Model\IndexUUID;

class RepositoryReferenceBuilder
{
    public static function createFromConfiguration(Configuration $configuration): RepositoryReference
    {
        if ($configuration->getIndex()) {
            return RepositoryReference::create(
                AppUUID::createById($configuration->getAppId()),
                IndexUUID::createById($configuration->getIndex())
            );
        }

        return RepositoryReference::create(
            AppUUID::createById($configuration->getAppId())
        );
    }
}
