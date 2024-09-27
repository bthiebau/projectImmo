<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240927133333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bien_immo (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, property_type_id INT NOT NULL, owner_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, address VARCHAR(255) NOT NULL, surface DOUBLE PRECISION NOT NULL, nb_rooms INT NOT NULL, nb_bedrooms INT NOT NULL, price DOUBLE PRECISION NOT NULL, year_of_construction INT NOT NULL, elevator TINYINT(1) DEFAULT NULL, balcony TINYINT(1) DEFAULT NULL, garden TINYINT(1) DEFAULT NULL, swimming_pool TINYINT(1) DEFAULT NULL, parking TINYINT(1) DEFAULT NULL, publication_date DATETIME NOT NULL, reference VARCHAR(255) NOT NULL, picture_name VARCHAR(255) DEFAULT NULL, INDEX IDX_174DAB78BAC62AF (city_id), INDEX IDX_174DAB79C81C6EB (property_type_id), INDEX IDX_174DAB77E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bien_immo ADD CONSTRAINT FK_174DAB78BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE bien_immo ADD CONSTRAINT FK_174DAB79C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id)');
        $this->addSql('ALTER TABLE bien_immo ADD CONSTRAINT FK_174DAB77E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien_immo DROP FOREIGN KEY FK_174DAB78BAC62AF');
        $this->addSql('ALTER TABLE bien_immo DROP FOREIGN KEY FK_174DAB79C81C6EB');
        $this->addSql('ALTER TABLE bien_immo DROP FOREIGN KEY FK_174DAB77E3C61F9');
        $this->addSql('DROP TABLE bien_immo');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE property_type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
