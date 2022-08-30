<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830080753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE8C68C142');
        $this->addSql('DROP INDEX UNIQ_E00CEDDE8C68C142 ON booking');
        $this->addSql('ALTER TABLE booking ADD meeting_room_id INT NOT NULL, DROP meeting_room_id_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDECCC5381E FOREIGN KEY (meeting_room_id) REFERENCES meeting_room (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDECCC5381E ON booking (meeting_room_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDECCC5381E');
        $this->addSql('DROP INDEX IDX_E00CEDDECCC5381E ON booking');
        $this->addSql('ALTER TABLE booking ADD meeting_room_id_id INT DEFAULT NULL, DROP meeting_room_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8C68C142 FOREIGN KEY (meeting_room_id_id) REFERENCES meeting_room (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE8C68C142 ON booking (meeting_room_id_id)');
    }
}
