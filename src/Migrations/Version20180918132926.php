<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use MyHammer\Api\Migrations\AbstractMigration;

/**
 * Class Version20180918132926
 * @package DoctrineMigrations
 */
final class Version20180918132926 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema): void
    {
        parent::up($schema);

        $this->addSql(
            'CREATE TABLE jobs
            (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL,
                city_id VARCHAR(255) NOT NULL,
                service_id INT UNSIGNED NOT NULL,
                created_by INT UNSIGNED NOT NULL,
                title VARCHAR(255) NOT NULL,
                description LONGTEXT NOT NULL,
                schedule ENUM(\'ASAP\', \'Today\', \'Tomorrow\', \'Next week\') NOT NULL COMMENT \'(DC2Type:enumSchedule)\',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                INDEX IDX_A8936DC58BAC62AF (city_id),
                INDEX IDX_A8936DC5ED5CA9E6 (service_id),
                INDEX IDX_A8936DC5DE12AB56 (created_by),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE jobs
            ADD CONSTRAINT FK_A8936DC58BAC62AF FOREIGN KEY (city_id) REFERENCES cities (zip)'
        );
        $this->addSql(
            'ALTER TABLE jobs
            ADD CONSTRAINT FK_A8936DC5ED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)'
        );
        $this->addSql(
            'ALTER TABLE jobs
            ADD CONSTRAINT FK_A8936DC5DE12AB56 FOREIGN KEY (created_by) REFERENCES users (id)'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema): void
    {
        parent::down($schema);

        $this->addSql('DROP TABLE jobs');
    }
}
