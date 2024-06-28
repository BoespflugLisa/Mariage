<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220164719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE donation_promise (id INT AUTO_INCREMENT NOT NULL, present_id INT NOT NULL, name VARCHAR(255) NOT NULL, donation_amount DOUBLE PRECISION NOT NULL, message LONGTEXT DEFAULT NULL, email VARCHAR(50) NOT NULL, view TINYINT(1) NOT NULL, INDEX IDX_B1A0DF208D7B1EF8 (present_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, img VARCHAR(255) NOT NULL, publisher VARCHAR(255) NOT NULL, visibility TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE present (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, img VARCHAR(255) DEFAULT NULL, parent_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_picture (tag_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_24EA6223BAD26311 (tag_id), INDEX IDX_24EA6223EE45BDBF (picture_id), PRIMARY KEY(tag_id, picture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(190) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donation_promise ADD CONSTRAINT FK_B1A0DF208D7B1EF8 FOREIGN KEY (present_id) REFERENCES present (id)');
        $this->addSql('ALTER TABLE tag_picture ADD CONSTRAINT FK_24EA6223BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_picture ADD CONSTRAINT FK_24EA6223EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE donation_promise DROP FOREIGN KEY FK_B1A0DF208D7B1EF8');
        $this->addSql('ALTER TABLE tag_picture DROP FOREIGN KEY FK_24EA6223BAD26311');
        $this->addSql('ALTER TABLE tag_picture DROP FOREIGN KEY FK_24EA6223EE45BDBF');
        $this->addSql('DROP TABLE donation_promise');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE present');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_picture');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
