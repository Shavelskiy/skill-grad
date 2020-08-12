<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200809182440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE provider_requisites ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER provider_id DROP NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ADD CONSTRAINT FK_A907D8EEA53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A907D8EEA53A8AA ON provider_requisites (provider_id)');
        $this->addSql('ALTER TABLE provider_requisites ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE provider_requisites DROP CONSTRAINT FK_A907D8EEA53A8AA');
        $this->addSql('DROP INDEX UNIQ_A907D8EEA53A8AA');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE provider_requisites DROP id');
        $this->addSql('ALTER TABLE provider_requisites ALTER provider_id SET NOT NULL');
    }
}
