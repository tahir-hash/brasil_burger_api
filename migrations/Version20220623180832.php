<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623180832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boisson ADD CONSTRAINT FK_8B97C84D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_8B97C84D6885AC1B ON boisson (gestionnaire_id)');
        $this->addSql('ALTER TABLE burger CHANGE catalogue_id catalogue_id INT NOT NULL, CHANGE gestionnaire_id gestionnaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A936885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_7D053A936885AC1B ON menu (gestionnaire_id)');
        $this->addSql('ALTER TABLE portion_frite ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE portion_frite ADD CONSTRAINT FK_8F393CAD6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_8F393CAD6885AC1B ON portion_frite (gestionnaire_id)');
        $this->addSql('ALTER TABLE taille CHANGE complement_id complement_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson DROP FOREIGN KEY FK_8B97C84D6885AC1B');
        $this->addSql('DROP INDEX IDX_8B97C84D6885AC1B ON boisson');
        $this->addSql('ALTER TABLE boisson DROP gestionnaire_id');
        $this->addSql('ALTER TABLE burger CHANGE catalogue_id catalogue_id INT DEFAULT NULL, CHANGE gestionnaire_id gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A936885AC1B');
        $this->addSql('DROP INDEX IDX_7D053A936885AC1B ON menu');
        $this->addSql('ALTER TABLE menu DROP gestionnaire_id');
        $this->addSql('ALTER TABLE portion_frite DROP FOREIGN KEY FK_8F393CAD6885AC1B');
        $this->addSql('DROP INDEX IDX_8F393CAD6885AC1B ON portion_frite');
        $this->addSql('ALTER TABLE portion_frite DROP gestionnaire_id');
        $this->addSql('ALTER TABLE taille CHANGE complement_id complement_id INT DEFAULT NULL');
    }
}
