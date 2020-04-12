<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200411225636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE upload_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE upload (id INT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP INDEX uniq_1483a5e9f85e0677');
        $this->addSql('ALTER TABLE users ADD avatar_id INT NOT NULL');
        $this->addSql('ALTER TABLE users ADD phone VARCHAR(11) NOT NULL');
        $this->addSql('ALTER TABLE users ADD full_name VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE users ADD about TEXT NOT NULL');
        $this->addSql('ALTER TABLE users ADD specialization VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE users RENAME COLUMN username TO email');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E986383B10 FOREIGN KEY (avatar_id) REFERENCES upload (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E986383B10 ON users (avatar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E986383B10');
        $this->addSql('DROP SEQUENCE upload_id_seq CASCADE');
        $this->addSql('DROP TABLE upload');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74');
        $this->addSql('DROP INDEX UNIQ_1483A5E986383B10');
        $this->addSql('ALTER TABLE users ADD username VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE users DROP avatar_id');
        $this->addSql('ALTER TABLE users DROP email');
        $this->addSql('ALTER TABLE users DROP phone');
        $this->addSql('ALTER TABLE users DROP full_name');
        $this->addSql('ALTER TABLE users DROP about');
        $this->addSql('ALTER TABLE users DROP specialization');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9f85e0677 ON users (username)');
    }
}
