<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251026115455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE gamer_id_seq CASCADE');
        $this->addSql('ALTER TABLE gamer DROP CONSTRAINT fk_88241ba7c69d3fb');
        $this->addSql('ALTER TABLE gamer DROP CONSTRAINT fk_88241ba7e48fd905');
        $this->addSql('DROP TABLE gamer');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE gamer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE gamer (id SERIAL NOT NULL, game_id INT NOT NULL, usr_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_88241ba7c69d3fb ON gamer (usr_id)');
        $this->addSql('CREATE INDEX idx_88241ba7e48fd905 ON gamer (game_id)');
        $this->addSql('ALTER TABLE gamer ADD CONSTRAINT fk_88241ba7c69d3fb FOREIGN KEY (usr_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gamer ADD CONSTRAINT fk_88241ba7e48fd905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
