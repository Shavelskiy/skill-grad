<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200608200821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE category (id INT NOT NULL, parent_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, sort INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');
        $this->addSql('CREATE INDEX IDX_64C19C1796A8F92 ON category (parent_category_id)');
        $this->addSql('CREATE TABLE program_question (id INT NOT NULL, user_id INT NOT NULL, program_id INT DEFAULT NULL, question TEXT NOT NULL, answer VARCHAR(255) DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_37C2B57BA76ED395 ON program_question (user_id)');
        $this->addSql('CREATE INDEX IDX_37C2B57B3EB8070A ON program_question (program_id)');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, name VARCHAR(255) NOT NULL, sort INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, active BOOLEAN DEFAULT \'false\' NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, social_key VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_info (user_id INT NOT NULL, full_name VARCHAR(180) DEFAULT NULL, phone VARCHAR(11) DEFAULT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE TABLE upload (id INT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, parent_location_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, sort INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E9E89CB6D6133FE ON location (parent_location_id)');
        $this->addSql('CREATE TABLE rubric (id INT NOT NULL, name VARCHAR(255) NOT NULL, sort INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE program (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_92ED7784A76ED395 ON program (user_id)');
        $this->addSql('CREATE TABLE program_category (program_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(program_id, category_id))');
        $this->addSql('CREATE INDEX IDX_8779E5F43EB8070A ON program_category (program_id)');
        $this->addSql('CREATE INDEX IDX_8779E5F412469DE2 ON program_category (category_id)');
        $this->addSql('CREATE TABLE program_request (id INT NOT NULL, user_id INT NOT NULL, program_id INT DEFAULT NULL, comment TEXT NOT NULL, status VARCHAR(255) NOT NULL, reject_reason VARCHAR(255) DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B07D774BA76ED395 ON program_request (user_id)');
        $this->addSql('CREATE INDEX IDX_B07D774B3EB8070A ON program_request (program_id)');
        $this->addSql('CREATE TABLE chat_message (id INT NOT NULL, user_id INT NOT NULL, recipient_id INT NOT NULL, message TEXT NOT NULL, date_send TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, viewed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FAB3FC16A76ED395 ON chat_message (user_id)');
        $this->addSql('CREATE INDEX IDX_FAB3FC16E92F8F78 ON chat_message (recipient_id)');
        $this->addSql('CREATE TABLE user_token (token UUID NOT NULL, user_id INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(user_id, token))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDF55A635F37A13B ON user_token (token)');
        $this->addSql('CREATE INDEX IDX_BDF55A63A76ED395 ON user_token (user_id)');
        $this->addSql('COMMENT ON COLUMN user_token.token IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1796A8F92 FOREIGN KEY (parent_category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_question ADD CONSTRAINT FK_37C2B57BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_question ADD CONSTRAINT FK_37C2B57B3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB6D6133FE FOREIGN KEY (parent_location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_category ADD CONSTRAINT FK_8779E5F43EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_category ADD CONSTRAINT FK_8779E5F412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_request ADD CONSTRAINT FK_B07D774BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_request ADD CONSTRAINT FK_B07D774B3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16E92F8F78 FOREIGN KEY (recipient_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_token ADD CONSTRAINT FK_BDF55A63A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C1796A8F92');
        $this->addSql('ALTER TABLE program_category DROP CONSTRAINT FK_8779E5F412469DE2');
        $this->addSql('ALTER TABLE program_question DROP CONSTRAINT FK_37C2B57BA76ED395');
        $this->addSql('ALTER TABLE user_info DROP CONSTRAINT FK_B1087D9EA76ED395');
        $this->addSql('ALTER TABLE program DROP CONSTRAINT FK_92ED7784A76ED395');
        $this->addSql('ALTER TABLE program_request DROP CONSTRAINT FK_B07D774BA76ED395');
        $this->addSql('ALTER TABLE chat_message DROP CONSTRAINT FK_FAB3FC16A76ED395');
        $this->addSql('ALTER TABLE chat_message DROP CONSTRAINT FK_FAB3FC16E92F8F78');
        $this->addSql('ALTER TABLE user_token DROP CONSTRAINT FK_BDF55A63A76ED395');
        $this->addSql('ALTER TABLE location DROP CONSTRAINT FK_5E9E89CB6D6133FE');
        $this->addSql('ALTER TABLE program_question DROP CONSTRAINT FK_37C2B57B3EB8070A');
        $this->addSql('ALTER TABLE program_category DROP CONSTRAINT FK_8779E5F43EB8070A');
        $this->addSql('ALTER TABLE program_request DROP CONSTRAINT FK_B07D774B3EB8070A');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE program_question');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('DROP TABLE upload');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE rubric');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE program_category');
        $this->addSql('DROP TABLE program_request');
        $this->addSql('DROP TABLE chat_message');
        $this->addSql('DROP TABLE user_token');
    }
}
