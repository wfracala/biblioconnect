<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127193138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rental (id INT AUTO_INCREMENT NOT NULL, item_id_id INT NOT NULL, user_id_id INT NOT NULL, rent_from DATETIME NOT NULL, rent_to DATETIME NOT NULL, INDEX IDX_1619C27D55E38587 (item_id_id), INDEX IDX_1619C27D9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D55E38587 FOREIGN KEY (item_id_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental DROP FOREIGN KEY FK_1619C27D55E38587');
        $this->addSql('ALTER TABLE rental DROP FOREIGN KEY FK_1619C27D9D86650F');
        $this->addSql('DROP TABLE rental');
    }
}
