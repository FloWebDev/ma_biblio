<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421232845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_user (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, username VARCHAR(128) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(256) NOT NULL, avatar VARCHAR(64) DEFAULT NULL, slug VARCHAR(128) NOT NULL, bio LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, connected_at DATETIME DEFAULT NULL, public TINYINT(1) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_88BDF3E9F85E0677 (username), UNIQUE INDEX UNIQ_88BDF3E9989D9B62 (slug), INDEX IDX_88BDF3E9D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(32) NOT NULL, name VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(32) NOT NULL, name VARCHAR(64) NOT NULL, css VARCHAR(32) DEFAULT NULL, order_z SMALLINT DEFAULT NULL, UNIQUE INDEX UNIQ_64C19C1AEA34913 (reference), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, topic VARCHAR(128) DEFAULT NULL, title VARCHAR(128) DEFAULT NULL, body LONGTEXT DEFAULT NULL, order_z SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, category_id INT DEFAULT NULL, reference VARCHAR(32) NOT NULL, title VARCHAR(512) NOT NULL, subtitle VARCHAR(256) DEFAULT NULL, author VARCHAR(256) DEFAULT NULL, published_date VARCHAR(32) DEFAULT NULL, description LONGTEXT DEFAULT NULL, isbn_13 VARCHAR(16) DEFAULT NULL, isbn_10 VARCHAR(16) DEFAULT NULL, image VARCHAR(512) DEFAULT NULL, file VARCHAR(32) DEFAULT NULL, litteral_category VARCHAR(256) DEFAULT NULL, note SMALLINT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_CBE5A331A76ED395 (user_id), INDEX IDX_CBE5A33112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E9D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331A76ED395');
        $this->addSql('ALTER TABLE app_user DROP FOREIGN KEY FK_88BDF3E9D60322AC');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33112469DE2');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE book');
    }
}
