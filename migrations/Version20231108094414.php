<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108094414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE tags_id_seq CASCADE');
        $this->addSql('ALTER TABLE tags DROP CONSTRAINT fk_6fbc942671179cd6');
        $this->addSql('DROP TABLE tags');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE tags_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tags (id INT NOT NULL, name_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_6fbc942671179cd6 ON tags (name_id)');
        $this->addSql('ALTER TABLE tags ADD CONSTRAINT fk_6fbc942671179cd6 FOREIGN KEY (name_id) REFERENCES news (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
