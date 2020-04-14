<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414193506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_88BDF3E9F85E0677');
        $this->addSql('DROP INDEX UNIQ_88BDF3E9989D9B62');
        $this->addSql('DROP INDEX IDX_88BDF3E9D60322AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_user AS SELECT id, role_id, username, password, email, avatar, slug, bio, created_at, connected_at, public, active FROM app_user');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('CREATE TABLE app_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER DEFAULT NULL, username VARCHAR(128) NOT NULL COLLATE BINARY, password VARCHAR(64) NOT NULL COLLATE BINARY, email VARCHAR(256) NOT NULL COLLATE BINARY, avatar VARCHAR(64) DEFAULT NULL COLLATE BINARY, slug VARCHAR(128) NOT NULL COLLATE BINARY, bio CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME NOT NULL, connected_at DATETIME DEFAULT NULL, public BOOLEAN NOT NULL, active BOOLEAN NOT NULL, CONSTRAINT FK_88BDF3E9D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO app_user (id, role_id, username, password, email, avatar, slug, bio, created_at, connected_at, public, active) SELECT id, role_id, username, password, email, avatar, slug, bio, created_at, connected_at, public, active FROM __temp__app_user');
        $this->addSql('DROP TABLE __temp__app_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E0677 ON app_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9989D9B62 ON app_user (slug)');
        $this->addSql('CREATE INDEX IDX_88BDF3E9D60322AC ON app_user (role_id)');
        $this->addSql('ALTER TABLE category ADD COLUMN css VARCHAR(32) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_CBE5A331A76ED395');
        $this->addSql('DROP INDEX IDX_CBE5A33112469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, user_id, category_id, reference, title, subtitle, author, published_date, description, isbn_13, isbn_10, image, litteral_category, note, created_at, comment FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, category_id INTEGER DEFAULT NULL, reference VARCHAR(32) NOT NULL COLLATE BINARY, title VARCHAR(512) NOT NULL COLLATE BINARY, subtitle VARCHAR(256) DEFAULT NULL COLLATE BINARY, author VARCHAR(256) DEFAULT NULL COLLATE BINARY, published_date VARCHAR(16) DEFAULT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, isbn_13 VARCHAR(16) DEFAULT NULL COLLATE BINARY, isbn_10 VARCHAR(16) DEFAULT NULL COLLATE BINARY, image VARCHAR(512) DEFAULT NULL COLLATE BINARY, litteral_category VARCHAR(256) DEFAULT NULL COLLATE BINARY, note SMALLINT DEFAULT NULL, created_at DATETIME DEFAULT NULL, comment CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_CBE5A331A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO book (id, user_id, category_id, reference, title, subtitle, author, published_date, description, isbn_13, isbn_10, image, litteral_category, note, created_at, comment) SELECT id, user_id, category_id, reference, title, subtitle, author, published_date, description, isbn_13, isbn_10, image, litteral_category, note, created_at, comment FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A331A76ED395 ON book (user_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_88BDF3E9F85E0677');
        $this->addSql('DROP INDEX UNIQ_88BDF3E9989D9B62');
        $this->addSql('DROP INDEX IDX_88BDF3E9D60322AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_user AS SELECT id, role_id, username, password, email, avatar, slug, bio, created_at, connected_at, public, active FROM app_user');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('CREATE TABLE app_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER DEFAULT NULL, username VARCHAR(128) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(256) NOT NULL, avatar VARCHAR(64) DEFAULT NULL, slug VARCHAR(128) NOT NULL, bio CLOB DEFAULT NULL, created_at DATETIME NOT NULL, connected_at DATETIME DEFAULT NULL, public BOOLEAN NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO app_user (id, role_id, username, password, email, avatar, slug, bio, created_at, connected_at, public, active) SELECT id, role_id, username, password, email, avatar, slug, bio, created_at, connected_at, public, active FROM __temp__app_user');
        $this->addSql('DROP TABLE __temp__app_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E0677 ON app_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9989D9B62 ON app_user (slug)');
        $this->addSql('CREATE INDEX IDX_88BDF3E9D60322AC ON app_user (role_id)');
        $this->addSql('DROP INDEX IDX_CBE5A331A76ED395');
        $this->addSql('DROP INDEX IDX_CBE5A33112469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, user_id, category_id, reference, title, subtitle, author, published_date, description, isbn_13, isbn_10, image, litteral_category, note, comment, created_at FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, category_id INTEGER DEFAULT NULL, reference VARCHAR(32) NOT NULL, title VARCHAR(512) NOT NULL, subtitle VARCHAR(256) DEFAULT NULL, author VARCHAR(256) DEFAULT NULL, published_date VARCHAR(16) DEFAULT NULL, description CLOB DEFAULT NULL, isbn_13 VARCHAR(16) DEFAULT NULL, isbn_10 VARCHAR(16) DEFAULT NULL, image VARCHAR(512) DEFAULT NULL, litteral_category VARCHAR(256) DEFAULT NULL, note SMALLINT DEFAULT NULL, comment CLOB DEFAULT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO book (id, user_id, category_id, reference, title, subtitle, author, published_date, description, isbn_13, isbn_10, image, litteral_category, note, comment, created_at) SELECT id, user_id, category_id, reference, title, subtitle, author, published_date, description, isbn_13, isbn_10, image, litteral_category, note, comment, created_at FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A331A76ED395 ON book (user_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, reference, name, order_z FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, reference VARCHAR(32) NOT NULL, name VARCHAR(64) NOT NULL, order_z SMALLINT DEFAULT NULL)');
        $this->addSql('INSERT INTO category (id, reference, name, order_z) SELECT id, reference, name, order_z FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
    }
}
