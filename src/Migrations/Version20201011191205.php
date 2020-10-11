<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201011191205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE program_program_include (program_id INT NOT NULL, program_include_id INT NOT NULL, PRIMARY KEY(program_id, program_include_id))');
        $this->addSql('CREATE INDEX IDX_5F6821603EB8070A ON program_program_include (program_id)');
        $this->addSql('CREATE INDEX IDX_5F682160FC34376B ON program_program_include (program_include_id)');
        $this->addSql('ALTER TABLE program_program_include ADD CONSTRAINT FK_5F6821603EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_program_include ADD CONSTRAINT FK_5F682160FC34376B FOREIGN KEY (program_include_id) REFERENCES program_include (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE program_include_program');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE program_include_program (program_include_id INT NOT NULL, program_id INT NOT NULL, PRIMARY KEY(program_include_id, program_id))');
        $this->addSql('CREATE INDEX idx_5c9d7e24fc34376b ON program_include_program (program_include_id)');
        $this->addSql('CREATE INDEX idx_5c9d7e243eb8070a ON program_include_program (program_id)');
        $this->addSql('ALTER TABLE program_include_program ADD CONSTRAINT fk_5c9d7e24fc34376b FOREIGN KEY (program_include_id) REFERENCES program_include (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_include_program ADD CONSTRAINT fk_5c9d7e243eb8070a FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE program_program_include');
    }
}
