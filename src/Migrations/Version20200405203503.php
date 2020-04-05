<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405203503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE chat_message DROP CONSTRAINT fk_fab3fc169d86650f');
        $this->addSql('ALTER TABLE chat_message DROP CONSTRAINT fk_fab3fc162b6945ec');
        $this->addSql('DROP INDEX idx_fab3fc169d86650f');
        $this->addSql('DROP INDEX idx_fab3fc162b6945ec');
        $this->addSql('ALTER TABLE chat_message ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE chat_message ADD recipient_id INT NOT NULL');
        $this->addSql('ALTER TABLE chat_message DROP user_id_id');
        $this->addSql('ALTER TABLE chat_message DROP recipient_id_id');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16E92F8F78 FOREIGN KEY (recipient_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FAB3FC16A76ED395 ON chat_message (user_id)');
        $this->addSql('CREATE INDEX IDX_FAB3FC16E92F8F78 ON chat_message (recipient_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chat_message DROP CONSTRAINT FK_FAB3FC16A76ED395');
        $this->addSql('ALTER TABLE chat_message DROP CONSTRAINT FK_FAB3FC16E92F8F78');
        $this->addSql('DROP INDEX IDX_FAB3FC16A76ED395');
        $this->addSql('DROP INDEX IDX_FAB3FC16E92F8F78');
        $this->addSql('ALTER TABLE chat_message ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE chat_message ADD recipient_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE chat_message DROP user_id');
        $this->addSql('ALTER TABLE chat_message DROP recipient_id');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT fk_fab3fc169d86650f FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT fk_fab3fc162b6945ec FOREIGN KEY (recipient_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fab3fc169d86650f ON chat_message (user_id_id)');
        $this->addSql('CREATE INDEX idx_fab3fc162b6945ec ON chat_message (recipient_id_id)');
    }
}
