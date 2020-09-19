<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910182410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE provider_categroy_additions (provider_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(provider_id, category_id))');
        $this->addSql('CREATE INDEX IDX_77C177DDA53A8AA ON provider_categroy_additions (provider_id)');
        $this->addSql('CREATE INDEX IDX_77C177DD12469DE2 ON provider_categroy_additions (category_id)');
        $this->addSql('ALTER TABLE provider_categroy_additions ADD CONSTRAINT FK_77C177DDA53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_categroy_additions ADD CONSTRAINT FK_77C177DD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE provider_categroy_group');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE provider_categroy_group (provider_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(provider_id, category_id))');
        $this->addSql('CREATE INDEX idx_671f45f812469de2 ON provider_categroy_group (category_id)');
        $this->addSql('CREATE INDEX idx_671f45f8a53a8aa ON provider_categroy_group (provider_id)');
        $this->addSql('ALTER TABLE provider_categroy_group ADD CONSTRAINT fk_671f45f8a53a8aa FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_categroy_group ADD CONSTRAINT fk_671f45f812469de2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE provider_categroy_additions');
    }
}
