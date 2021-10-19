<?php

/**
 * File that defines the Version20211019104413 class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class used to create page_template_block_type table.
 */
final class Version20211019104413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE page_template_block_type (id INT AUTO_INCREMENT NOT NULL, '
            . 'page_template_id INT DEFAULT NULL, block_type_id INT DEFAULT NULL, slug VARCHAR(50) NOT NULL, '
            . 'INDEX IDX_4A2CDC06126651CA (page_template_id), '
            . 'INDEX IDX_4A2CDC06BF6F786D (block_type_id), PRIMARY KEY(id)) '
            . 'DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE page_template_block_type ADD CONSTRAINT FK_4A2CDC06126651CA '
            . 'FOREIGN KEY (page_template_id) REFERENCES page_template (id)'
        );
        $this->addSql(
            'ALTER TABLE page_template_block_type ADD CONSTRAINT FK_4A2CDC06BF6F786D '
            . 'FOREIGN KEY (block_type_id) REFERENCES block_type (id)'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE page_template_block_type');
    }
}
