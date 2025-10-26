<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251026092202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id SERIAL NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE gamer (id SERIAL NOT NULL, game_id INT NOT NULL, usr_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_88241BA7E48FD905 ON gamer (game_id)');
        $this->addSql('CREATE INDEX IDX_88241BA7C69D3FB ON gamer (usr_id)');
        $this->addSql('ALTER TABLE gamer ADD CONSTRAINT FK_88241BA7E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gamer ADD CONSTRAINT FK_88241BA7C69D3FB FOREIGN KEY (usr_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gamer DROP CONSTRAINT FK_88241BA7E48FD905');
        $this->addSql('ALTER TABLE gamer DROP CONSTRAINT FK_88241BA7C69D3FB');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE gamer');
    }
}
