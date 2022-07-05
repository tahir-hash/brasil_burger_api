<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705154128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE gestionnaire_id gestionnaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE image image LONGBLOB NOT NULL, CHANGE prix prix INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE gestionnaire_id gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE prix prix INT DEFAULT NULL, CHANGE image image LONGBLOB DEFAULT NULL');
    }
}
