<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210530180537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE talla (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tallas_productos (id INT AUTO_INCREMENT NOT NULL, talla_id INT DEFAULT NULL, producto_id INT DEFAULT NULL, cantidad INT NOT NULL, INDEX IDX_221D1A795997DE7B (talla_id), INDEX IDX_221D1A797645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tallas_productos ADD CONSTRAINT FK_221D1A795997DE7B FOREIGN KEY (talla_id) REFERENCES talla (id)');
        $this->addSql('ALTER TABLE tallas_productos ADD CONSTRAINT FK_221D1A797645698E FOREIGN KEY (producto_id) REFERENCES productos (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tallas_productos DROP FOREIGN KEY FK_221D1A795997DE7B');
        $this->addSql('DROP TABLE talla');
        $this->addSql('DROP TABLE tallas_productos');
    }
}
