<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525131934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create service table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, service_catalog_id INT DEFAULT NULL, client_id INT DEFAULT NULL, service_date DATE DEFAULT NULL, note LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_E19D9AD25A6D5F48 (service_catalog_id), UNIQUE INDEX UNIQ_E19D9AD219EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD25A6D5F48 FOREIGN KEY (service_catalog_id) REFERENCES service_catalog (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD25A6D5F48');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD219EB6921');
        $this->addSql('DROP TABLE service');
    }
}
