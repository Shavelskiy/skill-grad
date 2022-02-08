<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614014544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE program DROP CONSTRAINT fk_92ed7784a76ed395');
        $this->addSql('DROP INDEX idx_92ed7784a76ed395');
        $this->addSql('ALTER TABLE program RENAME COLUMN user_id TO main_provider_id');
        $this->addSql('ALTER TABLE program RENAME COLUMN created TO created_at');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784DED0603C FOREIGN KEY (main_provider_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_92ED7784DED0603C ON program (main_provider_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE program DROP CONSTRAINT FK_92ED7784DED0603C');
        $this->addSql('DROP INDEX IDX_92ED7784DED0603C');
        $this->addSql('ALTER TABLE program RENAME COLUMN main_provider_id TO user_id');
        $this->addSql('ALTER TABLE program RENAME COLUMN created_at TO created');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT fk_92ed7784a76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_92ed7784a76ed395 ON program (user_id)');
    }
}
