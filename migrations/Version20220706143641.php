<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706143641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson_taille_commande (id INT AUTO_INCREMENT NOT NULL, boisson_taille_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, prix INT NOT NULL, INDEX IDX_F389E8C475B6EEA7 (boisson_taille_id), INDEX IDX_F389E8C482EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE burger_commande (id INT AUTO_INCREMENT NOT NULL, burger_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, prix INT NOT NULL, INDEX IDX_A0D9FE9917CE5090 (burger_id), INDEX IDX_A0D9FE9982EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_commande (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, prix INT NOT NULL, INDEX IDX_42BBE3EBCCD7E912 (menu_id), INDEX IDX_42BBE3EB82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portion_frite_commande (id INT AUTO_INCREMENT NOT NULL, portion_frite_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, prix INT NOT NULL, INDEX IDX_55BE86189B17FA7B (portion_frite_id), INDEX IDX_55BE861882EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson_taille_commande ADD CONSTRAINT FK_F389E8C475B6EEA7 FOREIGN KEY (boisson_taille_id) REFERENCES boisson_taille (id)');
        $this->addSql('ALTER TABLE boisson_taille_commande ADD CONSTRAINT FK_F389E8C482EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE burger_commande ADD CONSTRAINT FK_A0D9FE9917CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE burger_commande ADD CONSTRAINT FK_A0D9FE9982EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE menu_commande ADD CONSTRAINT FK_42BBE3EBCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_commande ADD CONSTRAINT FK_42BBE3EB82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE portion_frite_commande ADD CONSTRAINT FK_55BE86189B17FA7B FOREIGN KEY (portion_frite_id) REFERENCES portion_frite (id)');
        $this->addSql('ALTER TABLE portion_frite_commande ADD CONSTRAINT FK_55BE861882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('DROP TABLE produit_commande');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_commande (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, commande_id INT NOT NULL, quantite_produit INT NOT NULL, INDEX IDX_47F5946EF347EFB (produit_id), INDEX IDX_47F5946E82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946E82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('DROP TABLE boisson_taille_commande');
        $this->addSql('DROP TABLE burger_commande');
        $this->addSql('DROP TABLE menu_commande');
        $this->addSql('DROP TABLE portion_frite_commande');
    }
}
