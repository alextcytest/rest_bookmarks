<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160810145107 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, bookmark_id INT DEFAULT NULL, ip INT NOT NULL, text TEXT, create_at DATETIME NOT NULL, INDEX IDX_5F9E962A92741D25 (bookmark_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bookmarks (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(250) NOT NULL, url_hash CHAR(32) NOT NULL, create_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_78D2C140CFECAB00 (url_hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A92741D25 FOREIGN KEY (bookmark_id) REFERENCES bookmarks (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A92741D25');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE bookmarks');
    }
}

