<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623180429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger CHANGE catalogue_id catalogue_id INT NOT NULL, CHANGE gestionnaire_id gestionnaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE taille CHANGE complement_id complement_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger CHANGE catalogue_id catalogue_id INT DEFAULT NULL, CHANGE gestionnaire_id gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taille CHANGE complement_id complement_id INT DEFAULT NULL');
    }
}
