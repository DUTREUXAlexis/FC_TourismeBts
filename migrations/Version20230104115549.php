<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104115549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etablissement_utilisateur (etablissement_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_3A2A211FFF631228 (etablissement_id), INDEX IDX_3A2A211FFB88E14F (utilisateur_id), PRIMARY KEY(etablissement_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etablissement_utilisateur ADD CONSTRAINT FK_3A2A211FFF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etablissement_utilisateur ADD CONSTRAINT FK_3A2A211FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etablissement CHANGE modfied_at modfied_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement_utilisateur DROP FOREIGN KEY FK_3A2A211FFF631228');
        $this->addSql('ALTER TABLE etablissement_utilisateur DROP FOREIGN KEY FK_3A2A211FFB88E14F');
        $this->addSql('DROP TABLE etablissement_utilisateur');
        $this->addSql('ALTER TABLE etablissement CHANGE modfied_at modfied_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
