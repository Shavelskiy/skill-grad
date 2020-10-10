<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008230646 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE program DROP price');
        $this->addSql('ALTER TABLE program DROP discount');
        $this->addSql('ALTER TABLE program DROP term_of_payment');
        $this->addSql('ALTER TABLE program DROP old_price');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE program ADD price JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD discount JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD term_of_payment JSON NOT NULL');
        $this->addSql('ALTER TABLE program ADD old_price INT DEFAULT NULL');
    }
}
