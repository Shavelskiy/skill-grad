<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201009235841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE program_additional_program (program_additional_id INT NOT NULL, program_id INT NOT NULL, PRIMARY KEY(program_additional_id, program_id))');
        $this->addSql('CREATE INDEX IDX_8E3361DDFEBAB9BD ON program_additional_program (program_additional_id)');
        $this->addSql('CREATE INDEX IDX_8E3361DD3EB8070A ON program_additional_program (program_id)');
        $this->addSql('ALTER TABLE program_additional_program ADD CONSTRAINT FK_8E3361DDFEBAB9BD FOREIGN KEY (program_additional_id) REFERENCES program_additional (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_additional_program ADD CONSTRAINT FK_8E3361DD3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program ADD other_additional VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE program DROP additional');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE program_additional_program');
        $this->addSql('ALTER TABLE program ADD additional JSON NOT NULL');
        $this->addSql('ALTER TABLE program DROP other_additional');
    }
}
