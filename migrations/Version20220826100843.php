<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826100843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, week_slot_id_id INT NOT NULL, meeting_room_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, booking_id VARCHAR(255) NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, UNIQUE INDEX UNIQ_E00CEDDE11D166D0 (week_slot_id_id), UNIQUE INDEX UNIQ_E00CEDDE8C68C142 (meeting_room_id_id), UNIQUE INDEX UNIQ_E00CEDDE9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting_room (id INT AUTO_INCREMENT NOT NULL, room_name VARCHAR(255) NOT NULL, room_description LONGTEXT DEFAULT NULL, room_image_name VARCHAR(255) NOT NULL, max_person SMALLINT NOT NULL, rate VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, user_password VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, role JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week_slot (id INT AUTO_INCREMENT NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, week_day SMALLINT NOT NULL, is_opened TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE11D166D0 FOREIGN KEY (week_slot_id_id) REFERENCES week_slot (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8C68C142 FOREIGN KEY (meeting_room_id_id) REFERENCES meeting_room (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE11D166D0');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE8C68C142');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9D86650F');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE meeting_room');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE week_slot');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
