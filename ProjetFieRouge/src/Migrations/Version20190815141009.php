<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190815141009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, envoyeur_id INT DEFAULT NULL, beneficiaire_id INT DEFAULT NULL, caisier VARCHAR(255) NOT NULL, code BIGINT NOT NULL, montant BIGINT NOT NULL, frais BIGINT NOT NULL, total BIGINT NOT NULL, commissionsup BIGINT NOT NULL, commissionparte BIGINT NOT NULL, commissionetat BIGINT NOT NULL, datedenvoie DATETIME NOT NULL, dateretrait DATETIME NOT NULL, typedoperation VARCHAR(255) NOT NULL, INDEX IDX_723705D14795A786 (envoyeur_id), INDEX IDX_723705D15AF81F68 (beneficiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beneficiaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, numeropiece BIGINT NOT NULL, typepiece BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE envoyeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, numeropiece BIGINT NOT NULL, typepiece BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14795A786 FOREIGN KEY (envoyeur_id) REFERENCES envoyeur (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D15AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D15AF81F68');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14795A786');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE beneficiaire');
        $this->addSql('DROP TABLE envoyeur');
    }
}
