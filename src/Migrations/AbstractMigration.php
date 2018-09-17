<?php

namespace MyHammer\Api\Migrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration as DoctrineAbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Class AbstractMigration
 * @package MyHammer\Api\Migrations
 */
abstract class AbstractMigration extends DoctrineAbstractMigration
{
    const DATABASE_PLATFORM = 'mysql';
    const DATABASE_PLATFORM_ERROR_MESSAGE = 'Migration can only be executed safely on \'mysql\'.';

    /**
     * @param Schema $schema
     * @throws DBALException
     * @throws AbortMigrationException
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== self::DATABASE_PLATFORM,
            self::DATABASE_PLATFORM_ERROR_MESSAGE
        );
    }

    /**
     * @param Schema $schema
     * @throws AbortMigrationException
     * @throws DBALException
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== self::DATABASE_PLATFORM,
            self::DATABASE_PLATFORM_ERROR_MESSAGE
        );
    }
}
