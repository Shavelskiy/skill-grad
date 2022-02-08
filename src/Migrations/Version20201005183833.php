<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201005183833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE provider DROP pro_account');
        $this->addSql('ALTER TABLE provider DROP pro_account_expire_at');
        $this->addSql('ALTER TABLE service ADD provider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ALTER type SET NOT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E19D9AD2A53A8AA ON service (provider_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE service DROP CONSTRAINT FK_E19D9AD2A53A8AA');
        $this->addSql('DROP INDEX IDX_E19D9AD2A53A8AA');
        $this->addSql('ALTER TABLE service DROP provider_id');
        $this->addSql('ALTER TABLE service ALTER type DROP NOT NULL');
        $this->addSql('ALTER TABLE provider ADD pro_account BOOLEAN DEFAULT \'false\' NOT NULL');
        $this->addSql('ALTER TABLE provider ADD pro_account_expire_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }
}
