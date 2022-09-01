<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901142415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, movie_title VARCHAR(255) NOT NULL, movie_time INT NOT NULL, UNIQUE INDEX UNIQ_1D5EF26F557462F7 (movie_title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, room_number INT NOT NULL, capacity INT NOT NULL, UNIQUE INDEX UNIQ_729F519BD7DED995 (room_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `show` (id INT AUTO_INCREMENT NOT NULL, movie_id INT NOT NULL, room_id INT DEFAULT NULL, show_date DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_320ED9018F93B6FC (movie_id), INDEX IDX_320ED90154177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE show_seat (id INT AUTO_INCREMENT NOT NULL, show_id INT NOT NULL, ticket VARCHAR(255) NOT NULL, INDEX IDX_E1ABE0A5D0C1FC64 (show_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED9018F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90154177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE show_seat ADD CONSTRAINT FK_E1ABE0A5D0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED9018F93B6FC');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED90154177093');
        $this->addSql('ALTER TABLE show_seat DROP FOREIGN KEY FK_E1ABE0A5D0C1FC64');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE `show`');
        $this->addSql('DROP TABLE show_seat');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
