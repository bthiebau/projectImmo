<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240813124733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bien_immo ADD city_id INT NOT NULL, ADD property_type_id INT NOT NULL, DROP city, DROP property_type');
        $this->addSql('ALTER TABLE bien_immo ADD CONSTRAINT FK_174DAB78BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE bien_immo ADD CONSTRAINT FK_174DAB79C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id)');
        $this->addSql('CREATE INDEX IDX_174DAB78BAC62AF ON bien_immo (city_id)');
        $this->addSql('CREATE INDEX IDX_174DAB79C81C6EB ON bien_immo (property_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien_immo DROP FOREIGN KEY FK_174DAB78BAC62AF');
        $this->addSql('ALTER TABLE bien_immo DROP FOREIGN KEY FK_174DAB79C81C6EB');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE property_type');
        $this->addSql('DROP INDEX IDX_174DAB78BAC62AF ON bien_immo');
        $this->addSql('DROP INDEX IDX_174DAB79C81C6EB ON bien_immo');
        $this->addSql('ALTER TABLE bien_immo ADD city VARCHAR(255) NOT NULL, ADD property_type VARCHAR(255) NOT NULL, DROP city_id, DROP property_type_id');
    }
}
