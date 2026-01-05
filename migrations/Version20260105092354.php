<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260105092354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (event_id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_name VARCHAR(150) NOT NULL, event_date DATE NOT NULL, event_movie VARCHAR(150) NOT NULL, event_start DATETIME NOT NULL, event_end DATETIME NOT NULL, event_detail LONGTEXT DEFAULT NULL, event_max_participants SMALLINT NOT NULL, event_is_validated TINYINT(1) NOT NULL, event_movie_year DATE DEFAULT NULL, INDEX IDX_3BAE0AA7A76ED395 (user_id), PRIMARY KEY(event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_form (review_id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_id INT NOT NULL, review_note LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', review_body LONGTEXT DEFAULT NULL, INDEX IDX_B03CB057A76ED395 (user_id), INDEX IDX_B03CB05771F7E88B (event_id), PRIMARY KEY(review_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE take_part_in (user_id INT NOT NULL, event_id INT NOT NULL, user_has_confirmed TINYINT(1) NOT NULL, INDEX IDX_4F6C9296A76ED395 (user_id), INDEX IDX_4F6C929671F7E88B (event_id), PRIMARY KEY(user_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (user_id INT AUTO_INCREMENT NOT NULL, user_name VARCHAR(50) NOT NULL, user_role JSON NOT NULL COMMENT \'(DC2Type:json)\', user_email VARCHAR(100) NOT NULL, user_dob DATE DEFAULT NULL, user_country VARCHAR(255) DEFAULT NULL, user_password VARCHAR(255) NOT NULL, user_xp INT NOT NULL, user_status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USER_NAME (user_name), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE review_form ADD CONSTRAINT FK_B03CB057A76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE review_form ADD CONSTRAINT FK_B03CB05771F7E88B FOREIGN KEY (event_id) REFERENCES event (event_id)');
        $this->addSql('ALTER TABLE take_part_in ADD CONSTRAINT FK_4F6C9296A76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE take_part_in ADD CONSTRAINT FK_4F6C929671F7E88B FOREIGN KEY (event_id) REFERENCES event (event_id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A76ED395');
        $this->addSql('ALTER TABLE review_form DROP FOREIGN KEY FK_B03CB057A76ED395');
        $this->addSql('ALTER TABLE review_form DROP FOREIGN KEY FK_B03CB05771F7E88B');
        $this->addSql('ALTER TABLE take_part_in DROP FOREIGN KEY FK_4F6C9296A76ED395');
        $this->addSql('ALTER TABLE take_part_in DROP FOREIGN KEY FK_4F6C929671F7E88B');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE review_form');
        $this->addSql('DROP TABLE take_part_in');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
