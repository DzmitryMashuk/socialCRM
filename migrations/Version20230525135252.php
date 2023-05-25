<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525135252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrected references.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD service_catalogs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD29F2C19D8 FOREIGN KEY (service_catalogs_id) REFERENCES service_catalog (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD29F2C19D8 ON service (service_catalogs_id)');
        $this->addSql('ALTER TABLE service_catalog DROP FOREIGN KEY FK_D4A860DBED5CA9E6');
        $this->addSql('DROP INDEX IDX_D4A860DBED5CA9E6 ON service_catalog');
        $this->addSql('ALTER TABLE service_catalog DROP service_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_catalog ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service_catalog ADD CONSTRAINT FK_D4A860DBED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D4A860DBED5CA9E6 ON service_catalog (service_id)');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD29F2C19D8');
        $this->addSql('DROP INDEX IDX_E19D9AD29F2C19D8 ON service');
        $this->addSql('ALTER TABLE service DROP service_catalogs_id');
    }
}
