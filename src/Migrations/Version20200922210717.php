<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200922210717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE provider_categroy_additions');
        $this->addSql('DROP TABLE provider_location');
        $this->addSql('ALTER TABLE provider ADD location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE provider ADD CONSTRAINT FK_92C4739C64D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_92C4739C64D218E ON provider (location_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE provider_categroy_additions (provider_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(provider_id, category_id))');
        $this->addSql('CREATE INDEX idx_77c177dda53a8aa ON provider_categroy_additions (provider_id)');
        $this->addSql('CREATE INDEX idx_77c177dd12469de2 ON provider_categroy_additions (category_id)');
        $this->addSql('CREATE TABLE provider_location (provider_id INT NOT NULL, location_id INT NOT NULL, PRIMARY KEY(provider_id, location_id))');
        $this->addSql('CREATE INDEX idx_16dce72264d218e ON provider_location (location_id)');
        $this->addSql('CREATE INDEX idx_16dce722a53a8aa ON provider_location (provider_id)');
        $this->addSql('ALTER TABLE provider_categroy_additions ADD CONSTRAINT fk_77c177dda53a8aa FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_categroy_additions ADD CONSTRAINT fk_77c177dd12469de2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_location ADD CONSTRAINT fk_16dce722a53a8aa FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider_location ADD CONSTRAINT fk_16dce72264d218e FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE provider DROP CONSTRAINT FK_92C4739C64D218E');
        $this->addSql('DROP INDEX IDX_92C4739C64D218E');
        $this->addSql('ALTER TABLE provider DROP location_id');
    }
}
