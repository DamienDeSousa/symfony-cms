<?php

/**
 * File that defines the Version20210211184125 class.
 * This class is used to create site table on a migration.
 *
 * @author Damien DE SOUSA <dades@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210211184125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $query = 'CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, icon LONGTEXT ' .
            'DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB';
        $this->addSql($query);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE site');
    }
}
