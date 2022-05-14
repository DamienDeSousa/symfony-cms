<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514073847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_template_block_type DROP FOREIGN KEY FK_4A2CDC06126651CA');
        $this->addSql(
            'ALTER TABLE page_template_block_type ' .
            'ADD CONSTRAINT FK_4A2CDC06126651CA ' .
            'FOREIGN KEY (page_template_id) REFERENCES page_template (id) ON DELETE CASCADE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_template_block_type DROP FOREIGN KEY FK_4A2CDC06126651CA');
        $this->addSql(
            'ALTER TABLE page_template_block_type ' .
            'ADD CONSTRAINT FK_4A2CDC06126651CA ' .
            'FOREIGN KEY (page_template_id) REFERENCES page_template (id)'
        );
    }
}
