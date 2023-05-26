<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525134805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrected references.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE service DROP INDEX UNIQ_E19D9AD219EB6921, ADD INDEX IDX_E19D9AD219EB6921 (client_id)');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD25A6D5F48');
        $this->addSql('DROP INDEX UNIQ_E19D9AD25A6D5F48 ON service');
        $this->addSql('ALTER TABLE service CHANGE service_catalog_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2A76ED395 ON service (user_id)');
        $this->addSql('ALTER TABLE service_catalog ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service_catalog ADD CONSTRAINT FK_D4A860DBED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_D4A860DBED5CA9E6 ON service_catalog (service_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE service_catalog DROP FOREIGN KEY FK_D4A860DBED5CA9E6');
        $this->addSql('DROP INDEX IDX_D4A860DBED5CA9E6 ON service_catalog');
        $this->addSql('ALTER TABLE service_catalog DROP service_id');
        $this->addSql('ALTER TABLE service DROP INDEX IDX_E19D9AD219EB6921, ADD UNIQUE INDEX UNIQ_E19D9AD219EB6921 (client_id)');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A76ED395');
        $this->addSql('DROP INDEX IDX_E19D9AD2A76ED395 ON service');
        $this->addSql('ALTER TABLE service CHANGE user_id service_catalog_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD25A6D5F48 FOREIGN KEY (service_catalog_id) REFERENCES service_catalog (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E19D9AD25A6D5F48 ON service (service_catalog_id)');
    }
}
