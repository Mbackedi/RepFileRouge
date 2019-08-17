<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190815190619 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE beneficiaire ADD nomb VARCHAR(255) NOT NULL, ADD prenomb VARCHAR(255) NOT NULL, ADD adresseb VARCHAR(255) NOT NULL, ADD numpieceb BIGINT DEFAULT NULL, ADD typepieceb VARCHAR(255) DEFAULT NULL, DROP nom, DROP prenom, DROP adresse, DROP numeropiece, DROP typepiece, CHANGE telephone telephoneb INT NOT NULL');
        $this->addSql('ALTER TABLE envoyeur CHANGE typepiece typepiece VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE beneficiaire ADD nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD adresse VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD numeropiece BIGINT NOT NULL, ADD typepiece BIGINT NOT NULL, DROP nomb, DROP prenomb, DROP adresseb, DROP numpieceb, DROP typepieceb, CHANGE telephoneb telephone INT NOT NULL');
        $this->addSql('ALTER TABLE envoyeur CHANGE typepiece typepiece BIGINT NOT NULL');
    }
}
