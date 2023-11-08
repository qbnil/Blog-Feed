<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918093849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE comments_id_seq CASCADE');
        $this->addSql('DROP TABLE comments');
        $this->addSql('ALTER TABLE news ADD created_at_time VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE news ADD created_at_date VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE news DROP date');
        $this->addSql('ALTER TABLE news DROP create_at_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE comments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comments (id INT NOT NULL, comment_author VARCHAR(255) NOT NULL, comment_text TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN comments.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE news ADD date VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE news ADD create_at_time VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE news DROP created_at_time');
        $this->addSql('ALTER TABLE news DROP created_at_date');
    }
}
