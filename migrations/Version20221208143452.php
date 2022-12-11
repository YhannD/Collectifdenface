<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221208143452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exhibitions (id INT AUTO_INCREMENT NOT NULL, exhibitions_years_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, INDEX IDX_8FD2C1BC4AA5CFB1 (exhibitions_years_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exhibitions_images (id INT AUTO_INCREMENT NOT NULL, exhibition_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_62423B782A7D4494 (exhibition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exhibitions_years (id INT AUTO_INCREMENT NOT NULL, year VARCHAR(4) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias (id INT AUTO_INCREMENT NOT NULL, medias_sections_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(800) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, INDEX IDX_12D2AF8149F1EC98 (medias_sections_id), INDEX IDX_12D2AF81A76ED395 (user_id), FULLTEXT INDEX media (name, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias_categories (medias_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_B3EB52FAC7F4A74B (medias_id), INDEX IDX_B3EB52FAA21214B7 (categories_id), PRIMARY KEY(medias_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias_images (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D622A8B9EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias_musics (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BBF72374EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias_sections (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias_videos (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_1F9772E1EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, alias VARCHAR(255) NOT NULL, description VARCHAR(300) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_visible TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exhibitions ADD CONSTRAINT FK_8FD2C1BC4AA5CFB1 FOREIGN KEY (exhibitions_years_id) REFERENCES exhibitions_years (id)');
        $this->addSql('ALTER TABLE exhibitions_images ADD CONSTRAINT FK_62423B782A7D4494 FOREIGN KEY (exhibition_id) REFERENCES exhibitions (id)');
        $this->addSql('ALTER TABLE medias ADD CONSTRAINT FK_12D2AF8149F1EC98 FOREIGN KEY (medias_sections_id) REFERENCES medias_sections (id)');
        $this->addSql('ALTER TABLE medias ADD CONSTRAINT FK_12D2AF81A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE medias_categories ADD CONSTRAINT FK_B3EB52FAC7F4A74B FOREIGN KEY (medias_id) REFERENCES medias (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medias_categories ADD CONSTRAINT FK_B3EB52FAA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medias_images ADD CONSTRAINT FK_D622A8B9EA9FDD75 FOREIGN KEY (media_id) REFERENCES medias (id)');
        $this->addSql('ALTER TABLE medias_musics ADD CONSTRAINT FK_BBF72374EA9FDD75 FOREIGN KEY (media_id) REFERENCES medias (id)');
        $this->addSql('ALTER TABLE medias_videos ADD CONSTRAINT FK_1F9772E1EA9FDD75 FOREIGN KEY (media_id) REFERENCES medias (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exhibitions DROP FOREIGN KEY FK_8FD2C1BC4AA5CFB1');
        $this->addSql('ALTER TABLE exhibitions_images DROP FOREIGN KEY FK_62423B782A7D4494');
        $this->addSql('ALTER TABLE medias DROP FOREIGN KEY FK_12D2AF8149F1EC98');
        $this->addSql('ALTER TABLE medias DROP FOREIGN KEY FK_12D2AF81A76ED395');
        $this->addSql('ALTER TABLE medias_categories DROP FOREIGN KEY FK_B3EB52FAC7F4A74B');
        $this->addSql('ALTER TABLE medias_categories DROP FOREIGN KEY FK_B3EB52FAA21214B7');
        $this->addSql('ALTER TABLE medias_images DROP FOREIGN KEY FK_D622A8B9EA9FDD75');
        $this->addSql('ALTER TABLE medias_musics DROP FOREIGN KEY FK_BBF72374EA9FDD75');
        $this->addSql('ALTER TABLE medias_videos DROP FOREIGN KEY FK_1F9772E1EA9FDD75');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE exhibitions');
        $this->addSql('DROP TABLE exhibitions_images');
        $this->addSql('DROP TABLE exhibitions_years');
        $this->addSql('DROP TABLE medias');
        $this->addSql('DROP TABLE medias_categories');
        $this->addSql('DROP TABLE medias_images');
        $this->addSql('DROP TABLE medias_musics');
        $this->addSql('DROP TABLE medias_sections');
        $this->addSql('DROP TABLE medias_videos');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
