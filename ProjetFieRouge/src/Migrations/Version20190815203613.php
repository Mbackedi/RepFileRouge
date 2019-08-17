<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190815203613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD caissier_id INT NOT NULL, DROP caisier');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1B514973B FOREIGN KEY (caissier_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_723705D1B514973B ON transaction (caissier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1B514973B');
        $this->addSql('DROP INDEX IDX_723705D1B514973B ON transaction');
        $this->addSql('ALTER TABLE transaction ADD caisier VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP caissier_id');
    }
}
