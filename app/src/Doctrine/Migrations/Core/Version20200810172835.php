<?php

declare(strict_types=1);

namespace App\Doctrine\Migrations\Core;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810172835 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', email VARCHAR(32) DEFAULT NULL COMMENT \'(DC2Type:email)\', password_hash VARCHAR(255) NOT NULL, status TINYTEXT NOT NULL COMMENT \'(DC2Type:user_status)\', role VARCHAR(16) DEFAULT NULL COMMENT \'(DC2Type:user_role)\', confirm_token VARCHAR(255) DEFAULT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', name_first VARCHAR(16) NOT NULL, name_last VARCHAR(16) NOT NULL, reset_password_token VARCHAR(255) DEFAULT NULL, reset_password_expired_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
    }
}
