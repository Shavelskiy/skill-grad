<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200812211652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE feedback_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE feedback (id INT NOT NULL, author_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, text TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE article ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE article ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE article ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE program RENAME COLUMN updated TO updated_at');
        $this->addSql('ALTER TABLE program_request ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE program_request ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE program_request DROP created');
        $this->addSql('ALTER TABLE program_request DROP updated');
        $this->addSql('ALTER TABLE program_question ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE program_question ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE program_question DROP created');
        $this->addSql('ALTER TABLE program_question DROP updated');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE feedback_id_seq CASCADE');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('ALTER TABLE program_question ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE program_question ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE program_question DROP created_at');
        $this->addSql('ALTER TABLE program_question DROP updated_at');
        $this->addSql('ALTER TABLE program_request ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE program_request ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE program_request DROP created_at');
        $this->addSql('ALTER TABLE program_request DROP updated_at');
        $this->addSql('ALTER TABLE article DROP updated_at');
        $this->addSql('ALTER TABLE article ALTER created_at TYPE DATE');
        $this->addSql('ALTER TABLE article ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE program RENAME COLUMN updated_at TO updated');
    }
}
