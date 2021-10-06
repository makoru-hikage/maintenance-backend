<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211006101012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE floor (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, total_rows INT NOT NULL, total_cols INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE floor_area (id INT AUTO_INCREMENT NOT NULL, floor_id INT NOT NULL, area_code VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, floor_row INT NOT NULL, floor_col INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE floor');
        $this->addSql('DROP TABLE floor_area');
    }
}
