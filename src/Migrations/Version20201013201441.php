<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013201441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE seo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE seo (id INT NOT NULL, provider_id INT DEFAULT NULL, article_id INT DEFAULT NULL, program_id INT DEFAULT NULL, page_id INT DEFAULT NULL, meta_title TEXT DEFAULT NULL, meta_keywords TEXT DEFAULT NULL, meta_description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, dtype VARCHAR(255) NOT NULL, page_slug VARCHAR(255) DEFAULT NULL, page_description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6C71EC30A53A8AA ON seo (provider_id)');
        $this->addSql('CREATE INDEX IDX_6C71EC307294869C ON seo (article_id)');
        $this->addSql('CREATE INDEX IDX_6C71EC303EB8070A ON seo (program_id)');
        $this->addSql('CREATE INDEX IDX_6C71EC30C4663E4 ON seo (page_id)');
        $this->addSql('ALTER TABLE seo ADD CONSTRAINT FK_6C71EC30A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seo ADD CONSTRAINT FK_6C71EC307294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seo ADD CONSTRAINT FK_6C71EC303EB8070A FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seo ADD CONSTRAINT FK_6C71EC30C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE seo_id_seq CASCADE');
        $this->addSql('DROP TABLE seo');
    }
}
