<?php

/**
 * File that defines the Version20200901100257 class.
 * This class is used to create fos_user table on a migration.
 *
 * @author Damien DE SOUSA <dades@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901100257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $query = 'CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, ' .
            'username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, ' .
            'email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, ' .
            'password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, ' .
            'confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, ' .
            'roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ' .
            'UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), ' .
            'UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), ' .
            'UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), ' .
            'PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB';
        $this->addSql($query);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE fos_user');
    }
}
