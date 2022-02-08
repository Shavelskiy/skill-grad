<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200624154941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE certificate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE program_gallery_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE action_favorite_provider_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE program_level_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE certificate (id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_219CDA4A3DA5256D ON certificate (image_id)');
        $this->addSql('CREATE TABLE program_gallery (id INT NOT NULL, image_id INT DEFAULT NULL, program_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CCC180EE3DA5256D ON program_gallery (image_id)');
        $this->addSql('CREATE INDEX IDX_CCC180EE3EB8070A ON program_gallery (program_id)');
        $this->addSql('CREATE TABLE program_provider (program_id INT NOT NULL, provider_id INT NOT NULL, PRIMARY KEY(program_id, provider_id))');
        $this->addSql('CREATE INDEX IDX_13F18FA93EB8070A ON program_provider (program_id)');
        $this->addSql('CREATE INDEX IDX_13F18FA9A53A8AA ON program_provider (provider_id)');
        $this->addSql('CREATE TABLE program_location (program_id INT NOT NULL, location_id INT NOT NULL, PRIMARY KEY(program_id, location_id))');
        $this->addSql('CREATE INDEX IDX_DFAB75FE3EB8070A ON program_location (program_id)');
        $this->addSql('CREATE INDEX IDX_DFAB75FE64D218E ON program_location (location_id)');
        $this->addSql('CREATE TABLE action_favorite_provider (id INT NOT NULL, first_discount DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE program_level (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE certificate ADD CONSTRAINT FK_219CDA4A3DA5256D FOREIGN KEY (image_id) REFERENCES upload (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_gallery ADD CONSTRAINT FK_CCC180EE3DA5256D FOREIGN KEY (image_id) REFERENCES upload (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_gallery ADD CONSTRAINT FK_CCC180EE3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_provider ADD CONSTRAINT FK_13F18FA93EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_provider ADD CONSTRAINT FK_13F18FA9A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_location ADD CONSTRAINT FK_DFAB75FE3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_location ADD CONSTRAINT FK_DFAB75FE64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program DROP CONSTRAINT fk_92ed7784ded0603c');
        $this->addSql('DROP INDEX idx_92ed7784ded0603c');
        $this->addSql('ALTER TABLE program ADD level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program ADD certificate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program ADD action_favorite_provider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program ADD additional_info VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE program ADD process_description TEXT NOT NULL');
        $this->addSql('ALTER TABLE program ADD design JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD knowledge_check JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD additional JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD advantages JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD target_audience TEXT NOT NULL');
        $this->addSql('ALTER TABLE program ADD preparation TEXT NOT NULL');
        $this->addSql('ALTER TABLE program ADD gained_knowledge TEXT NOT NULL');
        $this->addSql('ALTER TABLE program ADD training_date JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD occupation_mode JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD location JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD includes JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD price JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD old_price JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD show_price_reduction BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE program ADD discount JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD provider_actions TEXT NOT NULL');
        $this->addSql('ALTER TABLE program RENAME COLUMN main_provider_id TO author_id');
        $this->addSql('COMMENT ON COLUMN program.target_audience IS \'(DC2Type:simple_array)\'');
        $this->addSql('COMMENT ON COLUMN program.preparation IS \'(DC2Type:simple_array)\'');
        $this->addSql('COMMENT ON COLUMN program.provider_actions IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784F675F31B FOREIGN KEY (author_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED77845FB14BA7 FOREIGN KEY (level_id) REFERENCES program_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778499223FFD FOREIGN KEY (certificate_id) REFERENCES certificate (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED77843DA7CE32 FOREIGN KEY (action_favorite_provider_id) REFERENCES action_favorite_provider (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_92ED7784F675F31B ON program (author_id)');
        $this->addSql('CREATE INDEX IDX_92ED77845FB14BA7 ON program (level_id)');
        $this->addSql('CREATE INDEX IDX_92ED778499223FFD ON program (certificate_id)');
        $this->addSql('CREATE INDEX IDX_92ED77843DA7CE32 ON program (action_favorite_provider_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE program DROP CONSTRAINT FK_92ED778499223FFD');
        $this->addSql('ALTER TABLE program DROP CONSTRAINT FK_92ED77843DA7CE32');
        $this->addSql('ALTER TABLE program DROP CONSTRAINT FK_92ED77845FB14BA7');
        $this->addSql('DROP SEQUENCE certificate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE program_gallery_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE action_favorite_provider_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE program_level_id_seq CASCADE');
        $this->addSql('DROP TABLE certificate');
        $this->addSql('DROP TABLE program_gallery');
        $this->addSql('DROP TABLE program_provider');
        $this->addSql('DROP TABLE program_location');
        $this->addSql('DROP TABLE action_favorite_provider');
        $this->addSql('DROP TABLE program_level');
        $this->addSql('ALTER TABLE program DROP CONSTRAINT FK_92ED7784F675F31B');
        $this->addSql('DROP INDEX IDX_92ED7784F675F31B');
        $this->addSql('DROP INDEX IDX_92ED77845FB14BA7');
        $this->addSql('DROP INDEX IDX_92ED778499223FFD');
        $this->addSql('DROP INDEX IDX_92ED77843DA7CE32');
        $this->addSql('ALTER TABLE program DROP level_id');
        $this->addSql('ALTER TABLE program DROP certificate_id');
        $this->addSql('ALTER TABLE program DROP action_favorite_provider_id');
        $this->addSql('ALTER TABLE program DROP additional_info');
        $this->addSql('ALTER TABLE program DROP process_description');
        $this->addSql('ALTER TABLE program DROP design');
        $this->addSql('ALTER TABLE program DROP knowledge_check');
        $this->addSql('ALTER TABLE program DROP additional');
        $this->addSql('ALTER TABLE program DROP advantages');
        $this->addSql('ALTER TABLE program DROP target_audience');
        $this->addSql('ALTER TABLE program DROP preparation');
        $this->addSql('ALTER TABLE program DROP gained_knowledge');
        $this->addSql('ALTER TABLE program DROP training_date');
        $this->addSql('ALTER TABLE program DROP occupation_mode');
        $this->addSql('ALTER TABLE program DROP location');
        $this->addSql('ALTER TABLE program DROP includes');
        $this->addSql('ALTER TABLE program DROP price');
        $this->addSql('ALTER TABLE program DROP old_price');
        $this->addSql('ALTER TABLE program DROP show_price_reduction');
        $this->addSql('ALTER TABLE program DROP discount');
        $this->addSql('ALTER TABLE program DROP provider_actions');
        $this->addSql('ALTER TABLE program RENAME COLUMN author_id TO main_provider_id');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT fk_92ed7784ded0603c FOREIGN KEY (main_provider_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_92ed7784ded0603c ON program (main_provider_id)');
    }
}
