<?php

declare(strict_types=1);

namespace App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200904095650 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subdomains_pages (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', sub_domain VARCHAR(255) NOT NULL COMMENT \'(DC2Type:subdomain)\', path VARCHAR(255) NOT NULL, template LONGTEXT NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_803B735715F85147 (sub_domain), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subdomains_pages ADD CONSTRAINT FK_803B735715F85147 FOREIGN KEY (sub_domain) REFERENCES subdomains (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE subdomains_pages');
    }
}
