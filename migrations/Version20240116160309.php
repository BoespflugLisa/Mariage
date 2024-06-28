<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116160309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE present_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE present ADD present_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE present ADD CONSTRAINT FK_FDBCAE176403F55B FOREIGN KEY (present_category_id) REFERENCES present_category (id)');
        $this->addSql('CREATE INDEX IDX_FDBCAE176403F55B ON present (present_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE present DROP FOREIGN KEY FK_FDBCAE176403F55B');
        $this->addSql('DROP TABLE present_category');
        $this->addSql('DROP INDEX IDX_FDBCAE176403F55B ON present');
        $this->addSql('ALTER TABLE present DROP present_category_id');
    }
}
