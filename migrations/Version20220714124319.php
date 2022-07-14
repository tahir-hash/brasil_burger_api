<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714124319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_menu_boisson_taille (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, boisson_taille_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_5AF24E3182EA2E54 (commande_id), INDEX IDX_5AF24E31CCD7E912 (menu_id), INDEX IDX_5AF24E3175B6EEA7 (boisson_taille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_menu_boisson_taille ADD CONSTRAINT FK_5AF24E3182EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande_menu_boisson_taille ADD CONSTRAINT FK_5AF24E31CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE commande_menu_boisson_taille ADD CONSTRAINT FK_5AF24E3175B6EEA7 FOREIGN KEY (boisson_taille_id) REFERENCES boisson_taille (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande_menu_boisson_taille');
    }
}
