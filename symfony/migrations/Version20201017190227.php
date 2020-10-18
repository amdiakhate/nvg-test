<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201017190227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inbound (id INT AUTO_INCREMENT NOT NULL, inventory_id INT NOT NULL, quantity INT NOT NULL, arrival_date DATETIME NOT NULL, INDEX IDX_D29032C99EEA759 (inventory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_B12D4A364584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory_channel (inventory_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_E3FD28BB9EEA759 (inventory_id), INDEX IDX_E3FD28BB72F5A1AA (channel_id), PRIMARY KEY(inventory_id, channel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inbound ADD CONSTRAINT FK_D29032C99EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A364584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE inventory_channel ADD CONSTRAINT FK_E3FD28BB9EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_channel ADD CONSTRAINT FK_E3FD28BB72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inbound DROP FOREIGN KEY FK_D29032C99EEA759');
        $this->addSql('ALTER TABLE inventory_channel DROP FOREIGN KEY FK_E3FD28BB9EEA759');
        $this->addSql('DROP TABLE inbound');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE inventory_channel');
    }
}
