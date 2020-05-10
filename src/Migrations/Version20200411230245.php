<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200411230245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE users ALTER avatar_id DROP NOT NULL');
        $this->addSql('ALTER TABLE users ALTER phone DROP NOT NULL');
        $this->addSql('ALTER TABLE users ALTER full_name DROP NOT NULL');
        $this->addSql('ALTER TABLE users ALTER about DROP NOT NULL');
        $this->addSql('ALTER TABLE users ALTER specialization DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users ALTER avatar_id SET NOT NULL');
        $this->addSql('ALTER TABLE users ALTER phone SET NOT NULL');
        $this->addSql('ALTER TABLE users ALTER full_name SET NOT NULL');
        $this->addSql('ALTER TABLE users ALTER about SET NOT NULL');
        $this->addSql('ALTER TABLE users ALTER specialization SET NOT NULL');
    }
}
