<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200809175604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE user_info_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE user_info ADD id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1087D9EA76ED395 ON user_info (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE user_info_id_seq CASCADE');
        $this->addSql('DROP INDEX UNIQ_B1087D9EA76ED395');
        $this->addSql('DROP INDEX user_info_pkey');
        $this->addSql('ALTER TABLE user_info DROP id');
        $this->addSql('ALTER TABLE user_info ALTER user_id SET NOT NULL');
        $this->addSql('ALTER TABLE user_info ADD PRIMARY KEY (user_id)');
    }
}
