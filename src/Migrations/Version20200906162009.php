<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906162009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE program ALTER author_id DROP NOT NULL');
        $this->addSql('ALTER TABLE program ALTER target_audience DROP NOT NULL');
        $this->addSql('ALTER TABLE program ALTER additional_info DROP NOT NULL');
        $this->addSql('ALTER TABLE program ALTER preparation DROP NOT NULL');
        $this->addSql('alter table program drop old_price');
        $this->addSql('ALTER TABLE program ADD old_price INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE program DROP old_price');
        $this->addSql('ALTER TABLE program ALTER preparation SET NOT NULL');
        $this->addSql('ALTER TABLE program ALTER additional_info SET NOT NULL');
        $this->addSql('ALTER TABLE program ALTER target_audience SET NOT NULL');
        $this->addSql('ALTER TABLE program ALTER author_id SET NOT NULL');
    }
}
