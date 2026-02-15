<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260215180702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carta DROP updated_at');
        $this->addSql('ALTER TABLE carta ADD CONSTRAINT FK_BDB93BE43397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E10122DE128CFD7 ON categoria (orden)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carta DROP FOREIGN KEY FK_BDB93BE43397707A');
        $this->addSql('ALTER TABLE carta ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_4E10122DE128CFD7 ON categoria');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BA76ED395');
    }
}
