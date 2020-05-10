<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510174243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE program_question ADD program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program_question ADD CONSTRAINT FK_37C2B57B3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_37C2B57B3EB8070A ON program_question (program_id)');
        $this->addSql('ALTER TABLE program_request ADD program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program_request ADD CONSTRAINT FK_B07D774B3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B07D774B3EB8070A ON program_request (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE program_question DROP CONSTRAINT FK_37C2B57B3EB8070A');
        $this->addSql('DROP INDEX IDX_37C2B57B3EB8070A');
        $this->addSql('ALTER TABLE program_question DROP program_id');
        $this->addSql('ALTER TABLE program_request DROP CONSTRAINT FK_B07D774B3EB8070A');
        $this->addSql('DROP INDEX IDX_B07D774B3EB8070A');
        $this->addSql('ALTER TABLE program_request DROP program_id');
    }
}
