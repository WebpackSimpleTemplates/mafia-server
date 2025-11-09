<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251102101704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP CONSTRAINT fk_232b318c4a4d0c45');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT fk_232b318cd04a0f27');
        $this->addSql('DROP INDEX idx_232b318c4a4d0c45');
        $this->addSql('DROP INDEX idx_232b318cd04a0f27');
        $this->addSql('ALTER TABLE game DROP speaker_id');
        $this->addSql('ALTER TABLE game DROP accent_id');
        $this->addSql('ALTER TABLE game DROP is_free_speech');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE game ADD speaker_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD accent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD is_free_speech BOOLEAN DEFAULT true NOT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT fk_232b318c4a4d0c45 FOREIGN KEY (accent_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT fk_232b318cd04a0f27 FOREIGN KEY (speaker_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_232b318c4a4d0c45 ON game (accent_id)');
        $this->addSql('CREATE INDEX idx_232b318cd04a0f27 ON game (speaker_id)');
    }
}
