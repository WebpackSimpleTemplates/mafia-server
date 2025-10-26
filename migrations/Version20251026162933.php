<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251026162933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dead_users (game_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(game_id, user_id))');
        $this->addSql('CREATE INDEX IDX_61B32892E48FD905 ON dead_users (game_id)');
        $this->addSql('CREATE INDEX IDX_61B32892A76ED395 ON dead_users (user_id)');
        $this->addSql('ALTER TABLE dead_users ADD CONSTRAINT FK_61B32892E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dead_users ADD CONSTRAINT FK_61B32892A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game ADD is_free_speech BOOLEAN DEFAULT true NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE dead_users DROP CONSTRAINT FK_61B32892E48FD905');
        $this->addSql('ALTER TABLE dead_users DROP CONSTRAINT FK_61B32892A76ED395');
        $this->addSql('DROP TABLE dead_users');
        $this->addSql('ALTER TABLE game DROP is_free_speech');
    }
}
