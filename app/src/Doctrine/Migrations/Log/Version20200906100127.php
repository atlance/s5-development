<?php

declare(strict_types=1);

namespace App\Doctrine\Migrations\Log;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906100127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE logs (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', sub_domain VARCHAR(16) NOT NULL COMMENT \'(DC2Type:subdomain)\', created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_F08FC65C15F85147 (sub_domain), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE logs');
    }
}
