<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210516182642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, con_talla TINYINT(1) NOT NULL, principal TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorias_productos (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, producto_id INT NOT NULL, INDEX IDX_2AA1DD383397707A (categoria_id), INDEX IDX_2AA1DD387645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorias_productos ADD CONSTRAINT FK_2AA1DD383397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE categorias_productos ADD CONSTRAINT FK_2AA1DD387645698E FOREIGN KEY (producto_id) REFERENCES productos (id)');
        $this->addSql('ALTER TABLE productos CHANGE precio precio INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorias_productos DROP FOREIGN KEY FK_2AA1DD383397707A');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE categorias_productos');
        $this->addSql('ALTER TABLE productos CHANGE precio precio INT NOT NULL COMMENT \'centimos\'');
    }
}
