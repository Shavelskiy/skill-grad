<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405201829 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE chat_message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chat_message (id INT NOT NULL, user_id_id INT NOT NULL, recipient_id_id INT NOT NULL, message TEXT NOT NULL, date_send DATE NOT NULL, viewed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FAB3FC169D86650F ON chat_message (user_id_id)');
        $this->addSql('CREATE INDEX IDX_FAB3FC162B6945EC ON chat_message (recipient_id_id)');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC169D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC162B6945EC FOREIGN KEY (recipient_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E95E4A4CA0 ON users (chat_token)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE chat_message_id_seq CASCADE');
        $this->addSql('DROP TABLE chat_message');
        $this->addSql('DROP INDEX UNIQ_1483A5E95E4A4CA0');
    }
}
