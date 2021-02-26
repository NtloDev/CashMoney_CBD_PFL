<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224120411 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone INT DEFAULT NULL, adress VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION DEFAULT NULL, lattitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(255) NOT NULL, telephone INT NOT NULL, cni INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, agences_id INT DEFAULT NULL, caissier_id INT DEFAULT NULL, numero_compte VARCHAR(255) NOT NULL, solde INT NOT NULL, date_creation DATE NOT NULL, statut TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_CFF652609917E4AB (agences_id), INDEX IDX_CFF65260B514973B (caissier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, transaction_depot_id INT DEFAULT NULL, client_id INT DEFAULT NULL, montant INT NOT NULL, date_depot DATE NOT NULL, date_retrait DATE DEFAULT NULL, code VARCHAR(255) NOT NULL, frais INT NOT NULL, frais_depot INT NOT NULL, frais_retrait INT NOT NULL, frais_etat INT NOT NULL, frais_system INT NOT NULL, INDEX IDX_723705D1F2C56620 (compte_id), INDEX IDX_723705D1CB62FDB6 (transaction_depot_id), INDEX IDX_723705D119EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF652609917E4AB FOREIGN KEY (agences_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260B514973B FOREIGN KEY (caissier_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1CB62FDB6 FOREIGN KEY (transaction_depot_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE user ADD agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D725330D ON user (agence_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF652609917E4AB');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D725330D');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D119EB6921');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F2C56620');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP INDEX IDX_8D93D649D725330D ON user');
        $this->addSql('ALTER TABLE user DROP agence_id');
    }
}
