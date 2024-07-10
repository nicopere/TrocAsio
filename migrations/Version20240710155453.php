<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710155453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounting_entry (id INT AUTO_INCREMENT NOT NULL, calculator_id INT DEFAULT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', amount DOUBLE PRECISION NOT NULL, receipt_number INT NOT NULL, name VARCHAR(255) NOT NULL, further_information VARCHAR(255) DEFAULT NULL, INDEX IDX_DB6C942AACF2C4B8 (calculator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calculator (id INT AUTO_INCREMENT NOT NULL, model VARCHAR(255) NOT NULL, note VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_operation (id INT AUTO_INCREMENT NOT NULL, calculator_id INT NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', action VARCHAR(255) NOT NULL, INDEX IDX_5C40821CACF2C4B8 (calculator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accounting_entry ADD CONSTRAINT FK_DB6C942AACF2C4B8 FOREIGN KEY (calculator_id) REFERENCES calculator (id)');
        $this->addSql('ALTER TABLE maintenance_operation ADD CONSTRAINT FK_5C40821CACF2C4B8 FOREIGN KEY (calculator_id) REFERENCES calculator (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounting_entry DROP FOREIGN KEY FK_DB6C942AACF2C4B8');
        $this->addSql('ALTER TABLE maintenance_operation DROP FOREIGN KEY FK_5C40821CACF2C4B8');
        $this->addSql('DROP TABLE accounting_entry');
        $this->addSql('DROP TABLE calculator');
        $this->addSql('DROP TABLE maintenance_operation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
