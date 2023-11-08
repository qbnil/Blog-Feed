<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108104600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE news_tags (news_id INT NOT NULL, tags_id INT NOT NULL, PRIMARY KEY(news_id, tags_id))');
        $this->addSql('CREATE INDEX IDX_BA6162ADB5A459A0 ON news_tags (news_id)');
        $this->addSql('CREATE INDEX IDX_BA6162AD8D7B4FB4 ON news_tags (tags_id)');
        $this->addSql('ALTER TABLE news_tags ADD CONSTRAINT FK_BA6162ADB5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE news_tags ADD CONSTRAINT FK_BA6162AD8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE news_tags DROP CONSTRAINT FK_BA6162ADB5A459A0');
        $this->addSql('ALTER TABLE news_tags DROP CONSTRAINT FK_BA6162AD8D7B4FB4');
        $this->addSql('DROP TABLE news_tags');
    }
}
