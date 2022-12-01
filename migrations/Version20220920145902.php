<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920145902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE exhibitions ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE medias ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP slug');
        $this->addSql('ALTER TABLE exhibitions DROP created_at, DROP slug');
        $this->addSql('ALTER TABLE medias DROP created_at, DROP slug');
        $this->addSql('ALTER TABLE users DROP slug');
    }
}
