<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010173018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, motivation LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module ADD etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_C242628DDEAB1A3 ON module (etudiant_id)');
        $this->addSql('ALTER TABLE niveau_scolaire ADD etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE niveau_scolaire ADD CONSTRAINT FK_5881678DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_5881678DDEAB1A3 ON niveau_scolaire (etudiant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628DDEAB1A3');
        $this->addSql('ALTER TABLE niveau_scolaire DROP FOREIGN KEY FK_5881678DDEAB1A3');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP INDEX IDX_C242628DDEAB1A3 ON module');
        $this->addSql('ALTER TABLE module DROP etudiant_id');
        $this->addSql('DROP INDEX IDX_5881678DDEAB1A3 ON niveau_scolaire');
        $this->addSql('ALTER TABLE niveau_scolaire DROP etudiant_id');
    }
}
