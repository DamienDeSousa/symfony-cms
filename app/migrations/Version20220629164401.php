<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629164401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD route_name VARCHAR(100) NOT NULL, ADD url VARCHAR(150) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_140AB620F3667F83 ON page (route_name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_140AB620F47645AE ON page (url)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_140AB620F3667F83 ON page');
        $this->addSql('DROP INDEX UNIQ_140AB620F47645AE ON page');
        $this->addSql('ALTER TABLE page DROP route_name, DROP url');
    }
}
