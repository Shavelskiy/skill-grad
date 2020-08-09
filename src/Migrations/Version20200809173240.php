<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200809173240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE provider_requisites ALTER organization_name DROP NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER legal_address DROP NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER itn DROP NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER iec DROP NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER okpo DROP NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER checking_account DROP NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER correspondent_account DROP NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER bic DROP NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER bank DROP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE provider_requisites ALTER organization_name SET NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER legal_address SET NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER itn SET NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER iec SET NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER okpo SET NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER checking_account SET NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER correspondent_account SET NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER bic SET NOT NULL');
        $this->addSql('ALTER TABLE provider_requisites ALTER bank SET NOT NULL');
    }
}
