<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525083833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create client table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, age INT NOT NULL, phone VARCHAR(25) DEFAULT NULL, guardian_name VARCHAR(255) DEFAULT NULL, guardian_phone VARCHAR(25) DEFAULT NULL, visit_days JSON NOT NULL, INDEX IDX_C7440455A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('DROP TABLE client');
    }
}
