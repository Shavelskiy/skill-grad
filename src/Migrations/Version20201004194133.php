<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004194133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE program_service ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program_service ADD active BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE program_service ADD price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE program_service ADD CONSTRAINT FK_6A776206A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6A776206A76ED395 ON program_service (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE program_service DROP CONSTRAINT FK_6A776206A76ED395');
        $this->addSql('DROP INDEX IDX_6A776206A76ED395');
        $this->addSql('ALTER TABLE program_service DROP user_id');
        $this->addSql('ALTER TABLE program_service DROP active');
        $this->addSql('ALTER TABLE program_service DROP price');
    }
}
