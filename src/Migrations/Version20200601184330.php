<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200601184330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE user_token (token UUID NOT NULL, user_id INT NOT NULL, PRIMARY KEY(user_id, token))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDF55A635F37A13B ON user_token (token)');
        $this->addSql('CREATE INDEX IDX_BDF55A63A76ED395 ON user_token (user_id)');
        $this->addSql('COMMENT ON COLUMN user_token.token IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_token ADD CONSTRAINT FK_BDF55A63A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX uniq_1483a5e95e4a4ca0');
        $this->addSql('DROP INDEX uniq_1483a5e9893565c3');
        $this->addSql('DROP INDEX uniq_1483a5e9452c9ec5');
        $this->addSql('ALTER TABLE users DROP chat_token');
        $this->addSql('ALTER TABLE users DROP reset_password_token');
        $this->addSql('ALTER TABLE users DROP register_token');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE user_token');
        $this->addSql('ALTER TABLE users ADD chat_token UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD reset_password_token UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD register_token UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN users.chat_token IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.reset_password_token IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.register_token IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e95e4a4ca0 ON users (chat_token)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9893565c3 ON users (register_token)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9452c9ec5 ON users (reset_password_token)');
    }
}
