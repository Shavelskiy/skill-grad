<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614003859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE teacher_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE teacher (id INT NOT NULL, photo_id INT DEFAULT NULL, program_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B0F6A6D57E9E4C8C ON teacher (photo_id)');
        $this->addSql('CREATE INDEX IDX_B0F6A6D53EB8070A ON teacher (program_id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D57E9E4C8C FOREIGN KEY (photo_id) REFERENCES upload (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D53EB8070A FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program ADD annotation TEXT NOT NULL');
        $this->addSql('ALTER TABLE program ADD detail_text TEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE teacher_id_seq CASCADE');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('ALTER TABLE program DROP annotation');
        $this->addSql('ALTER TABLE program DROP detail_text');
    }
}
