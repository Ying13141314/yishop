<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210601214720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tallas_productos DROP FOREIGN KEY FK_221D1A795997DE7B');
        $this->addSql('DROP TABLE talla');
        $this->addSql('DROP TABLE tallas_productos');
        $this->addSql('ALTER TABLE productos ADD xl INT DEFAULT NULL, ADD l INT DEFAULT NULL, ADD m INT DEFAULT NULL, ADD s INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE talla (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tallas_productos (id INT AUTO_INCREMENT NOT NULL, talla_id INT DEFAULT NULL, producto_id INT DEFAULT NULL, cantidad INT NOT NULL, INDEX IDX_221D1A797645698E (producto_id), INDEX IDX_221D1A795997DE7B (talla_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tallas_productos ADD CONSTRAINT FK_221D1A795997DE7B FOREIGN KEY (talla_id) REFERENCES talla (id)');
        $this->addSql('ALTER TABLE tallas_productos ADD CONSTRAINT FK_221D1A797645698E FOREIGN KEY (producto_id) REFERENCES productos (id)');
        $this->addSql('ALTER TABLE productos DROP xl, DROP l, DROP m, DROP s');
    }
}
