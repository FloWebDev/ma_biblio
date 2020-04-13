<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200412225633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE app_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER DEFAULT NULL, username VARCHAR(128) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(256) NOT NULL, avatar VARCHAR(64) DEFAULT NULL, slug VARCHAR(128) NOT NULL, bio CLOB DEFAULT NULL, created_at DATETIME NOT NULL, connected_at DATETIME DEFAULT NULL, public BOOLEAN NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E0677 ON app_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9989D9B62 ON app_user (slug)');
        $this->addSql('CREATE INDEX IDX_88BDF3E9D60322AC ON app_user (role_id)');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code VARCHAR(32) NOT NULL, name VARCHAR(32) NOT NULL)');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, reference VARCHAR(32) NOT NULL, name VARCHAR(64) NOT NULL, order_z SMALLINT DEFAULT NULL)');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, category_id INTEGER DEFAULT NULL, reference VARCHAR(32) NOT NULL, title VARCHAR(512) NOT NULL, subtitle VARCHAR(256) DEFAULT NULL, author VARCHAR(256) DEFAULT NULL, published_date VARCHAR(16) DEFAULT NULL, description CLOB DEFAULT NULL, isbn_13 VARCHAR(16) DEFAULT NULL, isbn_10 VARCHAR(16) DEFAULT NULL, image VARCHAR(512) DEFAULT NULL, litteral_category VARCHAR(256) DEFAULT NULL, note SMALLINT DEFAULT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_CBE5A331A76ED395 ON book (user_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE book');
    }
}
