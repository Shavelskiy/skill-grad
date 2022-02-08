<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201009234014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE program_include_program (program_include_id INT NOT NULL, program_id INT NOT NULL, PRIMARY KEY(program_include_id, program_id))');
        $this->addSql('CREATE INDEX IDX_5C9D7E24FC34376B ON program_include_program (program_include_id)');
        $this->addSql('CREATE INDEX IDX_5C9D7E243EB8070A ON program_include_program (program_id)');
        $this->addSql('ALTER TABLE program_include_program ADD CONSTRAINT FK_5C9D7E24FC34376B FOREIGN KEY (program_include_id) REFERENCES program_include (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_include_program ADD CONSTRAINT FK_5C9D7E243EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program ADD other_include VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE program DROP includes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE program_include_program');
        $this->addSql('ALTER TABLE program ADD includes JSON NOT NULL');
        $this->addSql('ALTER TABLE program DROP other_include');
    }
}
