<?php

declare(strict_types=1);

namespace App\Doctrine\Migrations\Core;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200826132206 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE companies (id VARCHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', sub_domain VARCHAR(16) DEFAULT NULL COMMENT \'(DC2Type:subdomain)\', created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', UNIQUE INDEX UNIQ_8244AA3A15F85147 (sub_domain), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subdomains (id VARCHAR(16) NOT NULL COMMENT \'(DC2Type:subdomain)\', created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3A15F85147 FOREIGN KEY (sub_domain) REFERENCES subdomains (id)');
        $this->addSql('ALTER TABLE users ADD company_id VARCHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', CHANGE id id VARCHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9979B1AD6 ON users (company_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9979B1AD6');
        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3A15F85147');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE subdomains');
        $this->addSql('DROP INDEX IDX_1483A5E9979B1AD6 ON users');
        $this->addSql('ALTER TABLE users DROP company_id, CHANGE id id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:user_id)\'');
    }
}
