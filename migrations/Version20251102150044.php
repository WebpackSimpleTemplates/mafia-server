<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251102150044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dead_users DROP CONSTRAINT fk_61b32892a76ed395');
        $this->addSql('ALTER TABLE dead_users DROP CONSTRAINT fk_61b32892e48fd905');
        $this->addSql('DROP TABLE dead_users');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT fk_232b318c13b3db11');
        $this->addSql('DROP INDEX idx_232b318c13b3db11');
        $this->addSql('ALTER TABLE game DROP master_id');
        $this->addSql('ALTER TABLE game DROP is_recruitmenting');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE dead_users (game_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(game_id, user_id))');
        $this->addSql('CREATE INDEX idx_61b32892a76ed395 ON dead_users (user_id)');
        $this->addSql('CREATE INDEX idx_61b32892e48fd905 ON dead_users (game_id)');
        $this->addSql('ALTER TABLE dead_users ADD CONSTRAINT fk_61b32892a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dead_users ADD CONSTRAINT fk_61b32892e48fd905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game ADD master_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD is_recruitmenting BOOLEAN DEFAULT true NOT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT fk_232b318c13b3db11 FOREIGN KEY (master_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_232b318c13b3db11 ON game (master_id)');
    }
}
