<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200409135749 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_88BDF3E9D60322AC');
        $this->addSql('DROP INDEX UNIQ_88BDF3E9989D9B62');
        $this->addSql('DROP INDEX UNIQ_88BDF3E9F85E0677');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_user AS SELECT id, role_id, username, password, email, slug, bio, created_at, connected_at, public, active FROM app_user');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('CREATE TABLE app_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER DEFAULT NULL, username VARCHAR(128) NOT NULL COLLATE BINARY, password VARCHAR(64) NOT NULL COLLATE BINARY, email VARCHAR(256) NOT NULL COLLATE BINARY, slug VARCHAR(128) NOT NULL COLLATE BINARY, bio CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME NOT NULL, connected_at DATETIME DEFAULT NULL, public BOOLEAN NOT NULL, active BOOLEAN NOT NULL, avatar VARCHAR(64) DEFAULT NULL, CONSTRAINT FK_88BDF3E9D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO app_user (id, role_id, username, password, email, slug, bio, created_at, connected_at, public, active) SELECT id, role_id, username, password, email, slug, bio, created_at, connected_at, public, active FROM __temp__app_user');
        $this->addSql('DROP TABLE __temp__app_user');
        $this->addSql('CREATE INDEX IDX_88BDF3E9D60322AC ON app_user (role_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9989D9B62 ON app_user (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E0677 ON app_user (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_88BDF3E9F85E0677');
        $this->addSql('DROP INDEX UNIQ_88BDF3E9989D9B62');
        $this->addSql('DROP INDEX IDX_88BDF3E9D60322AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_user AS SELECT id, role_id, username, password, email, slug, bio, created_at, connected_at, public, active FROM app_user');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('CREATE TABLE app_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER DEFAULT NULL, username VARCHAR(128) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(256) NOT NULL, slug VARCHAR(128) NOT NULL, bio CLOB DEFAULT NULL, created_at DATETIME NOT NULL, connected_at DATETIME DEFAULT NULL, public BOOLEAN NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO app_user (id, role_id, username, password, email, slug, bio, created_at, connected_at, public, active) SELECT id, role_id, username, password, email, slug, bio, created_at, connected_at, public, active FROM __temp__app_user');
        $this->addSql('DROP TABLE __temp__app_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E0677 ON app_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9989D9B62 ON app_user (slug)');
        $this->addSql('CREATE INDEX IDX_88BDF3E9D60322AC ON app_user (role_id)');
    }
}
