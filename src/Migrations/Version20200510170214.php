<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510170214 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE program_question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE program_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE program_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category_program (category_id INT NOT NULL, program_id INT NOT NULL, PRIMARY KEY(category_id, program_id))');
        $this->addSql('CREATE INDEX IDX_553537FA12469DE2 ON category_program (category_id)');
        $this->addSql('CREATE INDEX IDX_553537FA3EB8070A ON category_program (program_id)');
        $this->addSql('CREATE TABLE program_question (id INT NOT NULL, user_id INT NOT NULL, question TEXT NOT NULL, answer VARCHAR(255) DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_37C2B57BA76ED395 ON program_question (user_id)');
        $this->addSql('CREATE TABLE program (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_92ED7784A76ED395 ON program (user_id)');
        $this->addSql('CREATE TABLE program_category (program_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(program_id, category_id))');
        $this->addSql('CREATE INDEX IDX_8779E5F43EB8070A ON program_category (program_id)');
        $this->addSql('CREATE INDEX IDX_8779E5F412469DE2 ON program_category (category_id)');
        $this->addSql('CREATE TABLE program_request (id INT NOT NULL, user_id INT NOT NULL, comment TEXT NOT NULL, status VARCHAR(255) NOT NULL, reject_reason VARCHAR(255) DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B07D774BA76ED395 ON program_request (user_id)');
        $this->addSql('ALTER TABLE category_program ADD CONSTRAINT FK_553537FA12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_program ADD CONSTRAINT FK_553537FA3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_question ADD CONSTRAINT FK_37C2B57BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_category ADD CONSTRAINT FK_8779E5F43EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_category ADD CONSTRAINT FK_8779E5F412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_request ADD CONSTRAINT FK_B07D774BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category_program DROP CONSTRAINT FK_553537FA12469DE2');
        $this->addSql('ALTER TABLE program_category DROP CONSTRAINT FK_8779E5F412469DE2');
        $this->addSql('ALTER TABLE category_program DROP CONSTRAINT FK_553537FA3EB8070A');
        $this->addSql('ALTER TABLE program_category DROP CONSTRAINT FK_8779E5F43EB8070A');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE program_question_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE program_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE program_request_id_seq CASCADE');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_program');
        $this->addSql('DROP TABLE program_question');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE program_category');
        $this->addSql('DROP TABLE program_request');
    }
}
