<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525150438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrected references.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD29F2C19D8');
        $this->addSql('DROP INDEX IDX_E19D9AD29F2C19D8 ON service');
        $this->addSql('ALTER TABLE service CHANGE service_catalogs_id service_catalog_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD25A6D5F48 FOREIGN KEY (service_catalog_id) REFERENCES service_catalog (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD25A6D5F48 ON service (service_catalog_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD25A6D5F48');
        $this->addSql('DROP INDEX IDX_E19D9AD25A6D5F48 ON service');
        $this->addSql('ALTER TABLE service CHANGE service_catalog_id service_catalogs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD29F2C19D8 FOREIGN KEY (service_catalogs_id) REFERENCES service_catalog (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E19D9AD29F2C19D8 ON service (service_catalogs_id)');
    }
}
