<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use MyHammer\Api\Migrations\AbstractMigration;

/**
 * Class Version20180917125531
 * @package DoctrineMigrations
 */
final class Version20180917125531 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema): void
    {
        parent::up($schema);

        $this->addSql(
            'CREATE TABLE users
            (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL,
                username VARCHAR(255) NOT NULL,
                UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE services
            (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                UNIQUE INDEX UNIQ_7332E1695E237E06 (name),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE cities
            (
                zip VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY(zip)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema): void
    {
        parent::down($schema);

        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE cities');
    }
}
