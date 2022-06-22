<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622183202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boisson_taille (boisson_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_E7A2EE1734B8089 (boisson_id), INDEX IDX_E7A2EE1FF25611A (taille_id), PRIMARY KEY(boisson_id, taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE burger (id INT AUTO_INCREMENT NOT NULL, catalogue_id INT NOT NULL, INDEX IDX_EFE35A0D4A7843DC (catalogue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalogue (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, livraison_id INT DEFAULT NULL, gestionnaire_id INT NOT NULL, client_id INT NOT NULL, zone_id INT DEFAULT NULL, num_cmd VARCHAR(255) NOT NULL, date_cmd DATETIME NOT NULL, montant INT NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67D8E54FB25 (livraison_id), INDEX IDX_6EEAA67D6885AC1B (gestionnaire_id), INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D9F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE complement (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE complement_menu (complement_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_C653EA6B40D9D0AA (complement_id), INDEX IDX_C653EA6BCCD7E912 (menu_id), PRIMARY KEY(complement_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gestionnaire (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, livreur_id INT DEFAULT NULL, montant_total INT NOT NULL, INDEX IDX_A60C9F1FF8646701 (livreur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, matricule_moto VARCHAR(255) NOT NULL, telephone INT NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, catalogue_id INT NOT NULL, INDEX IDX_7D053A934A7843DC (catalogue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_burger (menu_id INT NOT NULL, burger_id INT NOT NULL, INDEX IDX_3CA402D5CCD7E912 (menu_id), INDEX IDX_3CA402D517CE5090 (burger_id), PRIMARY KEY(menu_id, burger_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portion_frite (id INT AUTO_INCREMENT NOT NULL, complement_id INT NOT NULL, INDEX IDX_8F393CAD40D9D0AA (complement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, prix INT NOT NULL, description LONGTEXT NOT NULL, etat VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_commande (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, commande_id INT NOT NULL, quantite_produit INT NOT NULL, INDEX IDX_47F5946EF347EFB (produit_id), INDEX IDX_47F5946E82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, zone_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_FEE8962D9F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille (id INT AUTO_INCREMENT NOT NULL, complement_id INT NOT NULL, prix INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_76508B3840D9D0AA (complement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D4A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE complement_menu ADD CONSTRAINT FK_C653EA6B40D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE complement_menu ADD CONSTRAINT FK_C653EA6BCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FF8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A934A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id)');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portion_frite ADD CONSTRAINT FK_8F393CAD40D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id)');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946E82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE taille ADD CONSTRAINT FK_76508B3840D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson_taille DROP FOREIGN KEY FK_E7A2EE1734B8089');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D517CE5090');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D4A7843DC');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A934A7843DC');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE produit_commande DROP FOREIGN KEY FK_47F5946E82EA2E54');
        $this->addSql('ALTER TABLE complement_menu DROP FOREIGN KEY FK_C653EA6B40D9D0AA');
        $this->addSql('ALTER TABLE portion_frite DROP FOREIGN KEY FK_8F393CAD40D9D0AA');
        $this->addSql('ALTER TABLE taille DROP FOREIGN KEY FK_76508B3840D9D0AA');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D6885AC1B');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D8E54FB25');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FF8646701');
        $this->addSql('ALTER TABLE complement_menu DROP FOREIGN KEY FK_C653EA6BCCD7E912');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D5CCD7E912');
        $this->addSql('ALTER TABLE produit_commande DROP FOREIGN KEY FK_47F5946EF347EFB');
        $this->addSql('ALTER TABLE boisson_taille DROP FOREIGN KEY FK_E7A2EE1FF25611A');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D9F2C3FAB');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D9F2C3FAB');
        $this->addSql('DROP TABLE boisson');
        $this->addSql('DROP TABLE boisson_taille');
        $this->addSql('DROP TABLE burger');
        $this->addSql('DROP TABLE catalogue');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE complement');
        $this->addSql('DROP TABLE complement_menu');
        $this->addSql('DROP TABLE gestionnaire');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_burger');
        $this->addSql('DROP TABLE portion_frite');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_commande');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE taille');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE zone');
    }
}
