<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614124720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE provider_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE provider_requisites (prover_id INT NOT NULL, organization_name VARCHAR(255) NOT NULL, legal_address VARCHAR(255) NOT NULL, mailing_address VARCHAR(255) DEFAULT NULL, itn VARCHAR(255) NOT NULL, iec VARCHAR(255) NOT NULL, psrn VARCHAR(255) DEFAULT NULL, okpo VARCHAR(255) NOT NULL, checking_account VARCHAR(255) NOT NULL, correspondent_account VARCHAR(255) NOT NULL, bic VARCHAR(255) NOT NULL, bank VARCHAR(255) NOT NULL, PRIMARY KEY(prover_id))');
        $this->addSql('CREATE TABLE provider (id INT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_92C4739CA76ED395 ON provider (user_id)');
        $this->addSql('CREATE TABLE provider_categroy_group (provider_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(provider_id, category_id))');
        $this->addSql('CREATE INDEX IDX_671F45F8A53A8AA ON provider_categroy_group (provider_id)');
        $this->addSql('CREATE INDEX IDX_671F45F812469DE2 ON provider_categroy_group (category_id)');
        $this->addSql('CREATE TABLE provider_category (provider_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(provider_id, category_id))');
        $this->addSql('CREATE INDEX IDX_4E0E7728A53A8AA ON provider_category (provider_id)');
        $this->addSql('CREATE INDEX IDX_4E0E772812469DE2 ON provider_category (category_id)');
        $this->addSql('CREATE TABLE provider_location (provider_id INT NOT NULL, location_id INT NOT NULL, PRIMARY KEY(provider_id, location_id))');
        $this->addSql('CREATE INDEX IDX_16DCE722A53A8AA ON provider_location (provider_id)');
        $this->addSql('CREATE INDEX IDX_16DCE72264D218E ON provider_location (location_id)');
        $this->addSql('ALTER TABLE provider_requisites ADD CONSTRAINT FK_A907D8EE51BE1F4E FOREIGN KEY (prover_id) REFERENCES provider (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider ADD CONSTRAINT FK_92C4739CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_categroy_group ADD CONSTRAINT FK_671F45F8A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_categroy_group ADD CONSTRAINT FK_671F45F812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_category ADD CONSTRAINT FK_4E0E7728A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_category ADD CONSTRAINT FK_4E0E772812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_location ADD CONSTRAINT FK_16DCE722A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_location ADD CONSTRAINT FK_16DCE72264D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE provider_requisites DROP CONSTRAINT FK_A907D8EE51BE1F4E');
        $this->addSql('ALTER TABLE provider_categroy_group DROP CONSTRAINT FK_671F45F8A53A8AA');
        $this->addSql('ALTER TABLE provider_category DROP CONSTRAINT FK_4E0E7728A53A8AA');
        $this->addSql('ALTER TABLE provider_location DROP CONSTRAINT FK_16DCE722A53A8AA');
        $this->addSql('DROP SEQUENCE provider_id_seq CASCADE');
        $this->addSql('DROP TABLE provider_requisites');
        $this->addSql('DROP TABLE provider');
        $this->addSql('DROP TABLE provider_categroy_group');
        $this->addSql('DROP TABLE provider_category');
        $this->addSql('DROP TABLE provider_location');
    }
}
