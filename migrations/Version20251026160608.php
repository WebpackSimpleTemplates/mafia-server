<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251026160608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD speaker_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD accent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD04A0F27 FOREIGN KEY (speaker_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C4A4D0C45 FOREIGN KEY (accent_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_232B318CD04A0F27 ON game (speaker_id)');
        $this->addSql('CREATE INDEX IDX_232B318C4A4D0C45 ON game (accent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318CD04A0F27');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318C4A4D0C45');
        $this->addSql('DROP INDEX IDX_232B318CD04A0F27');
        $this->addSql('DROP INDEX IDX_232B318C4A4D0C45');
        $this->addSql('ALTER TABLE game DROP speaker_id');
        $this->addSql('ALTER TABLE game DROP accent_id');
    }
}
