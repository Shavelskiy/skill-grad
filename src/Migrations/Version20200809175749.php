<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200809175749 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('alter table user_info drop constraint fk_b1087d9ea76ed395');
        $this->addSql('DROP INDEX "uniq_b1087d9ea76ed395"');
        $this->addSql('alter table user_info drop constraint user_info_pkey');
        $this->addSql('ALTER TABLE user_info ALTER user_id DROP NOT NULL');
        $this->addSql('ALTER TABLE user_info ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX user_info_pkey');
        $this->addSql('ALTER TABLE user_info ALTER user_id SET NOT NULL');
        $this->addSql('ALTER TABLE user_info ADD PRIMARY KEY (user_id)');
    }
}
