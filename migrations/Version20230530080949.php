<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530080949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create service_catalog_group table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE service_catalog_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_catalog ADD service_catalog_group_id INT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE service_catalog ADD CONSTRAINT FK_D4A860DB6BC62048 FOREIGN KEY (service_catalog_group_id) REFERENCES service_catalog_group (id)');
        $this->addSql('CREATE INDEX IDX_D4A860DB6BC62048 ON service_catalog (service_catalog_group_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE service_catalog DROP FOREIGN KEY FK_D4A860DB6BC62048');
        $this->addSql('DROP TABLE service_catalog_group');
        $this->addSql('DROP INDEX IDX_D4A860DB6BC62048 ON service_catalog');
        $this->addSql('ALTER TABLE service_catalog DROP service_catalog_group_id, CHANGE name name VARCHAR(255) DEFAULT NULL');
    }
}
