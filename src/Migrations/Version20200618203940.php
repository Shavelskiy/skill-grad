<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200618203940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE provider_requisites (provider_id INT NOT NULL, organization_name VARCHAR(255) NOT NULL, legal_address VARCHAR(255) NOT NULL, mailing_address VARCHAR(255) DEFAULT NULL, itn VARCHAR(255) NOT NULL, iec VARCHAR(255) NOT NULL, psrn VARCHAR(255) DEFAULT NULL, okpo VARCHAR(255) NOT NULL, checking_account VARCHAR(255) NOT NULL, correspondent_account VARCHAR(255) NOT NULL, bic VARCHAR(255) NOT NULL, bank VARCHAR(255) NOT NULL, PRIMARY KEY(provider_id))');
        $this->addSql('ALTER TABLE provider_requisites ADD CONSTRAINT FK_A907D8EEA53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE provider_requisites');
    }
}
