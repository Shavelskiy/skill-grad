<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200927010107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE article_comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article_comment (id INT NOT NULL, user_id INT DEFAULT NULL, parent_comment_id INT DEFAULT NULL, text TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_79A616DBA76ED395 ON article_comment (user_id)');
        $this->addSql('CREATE INDEX IDX_79A616DBBF2AF943 ON article_comment (parent_comment_id)');
        $this->addSql('ALTER TABLE article_comment ADD CONSTRAINT FK_79A616DBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_comment ADD CONSTRAINT FK_79A616DBBF2AF943 FOREIGN KEY (parent_comment_id) REFERENCES article_comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE article_comment DROP CONSTRAINT FK_79A616DBBF2AF943');
        $this->addSql('DROP SEQUENCE article_comment_id_seq CASCADE');
        $this->addSql('DROP TABLE article_comment');
    }
}
