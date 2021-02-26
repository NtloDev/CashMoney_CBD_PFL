<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225180603 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1CB62FDB6');
        $this->addSql('DROP INDEX IDX_723705D1CB62FDB6 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD emeteur_nom_complet VARCHAR(255) NOT NULL, ADD emmeteur_telephone INT NOT NULL, ADD beneficiaire_nom_complet VARCHAR(255) NOT NULL, ADD beneficiaire_telephone INT NOT NULL, DROP transaction_depot_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction ADD transaction_depot_id INT DEFAULT NULL, DROP emeteur_nom_complet, DROP emmeteur_telephone, DROP beneficiaire_nom_complet, DROP beneficiaire_telephone');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1CB62FDB6 FOREIGN KEY (transaction_depot_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_723705D1CB62FDB6 ON transaction (transaction_depot_id)');
    }
}
