<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260214100336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carta DROP orden, CHANGE nombre nombre VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE carta ADD CONSTRAINT FK_BDB93BE43397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('DROP INDEX UNIQ_4E10122D3A909126 ON categoria');
        $this->addSql('ALTER TABLE categoria ADD orden INT NOT NULL, CHANGE nombre nombre VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carta DROP FOREIGN KEY FK_BDB93BE43397707A');
        $this->addSql('ALTER TABLE carta ADD orden INT NOT NULL, CHANGE nombre nombre VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE categoria DROP orden, CHANGE nombre nombre VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E10122D3A909126 ON categoria (nombre)');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BA76ED395');
    }
}
