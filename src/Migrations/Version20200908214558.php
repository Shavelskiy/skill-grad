<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908214558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE user_program (user_id INT NOT NULL, program_id INT NOT NULL, PRIMARY KEY(user_id, program_id))');
        $this->addSql('CREATE INDEX IDX_CAE0698EA76ED395 ON user_program (user_id)');
        $this->addSql('CREATE INDEX IDX_CAE0698E3EB8070A ON user_program (program_id)');
        $this->addSql('ALTER TABLE user_program ADD CONSTRAINT FK_CAE0698EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_program ADD CONSTRAINT FK_CAE0698E3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE user_program');
    }
}
