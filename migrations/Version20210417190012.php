<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417190012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clientes (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, dni VARCHAR(15) NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, telefono VARCHAR(20) NOT NULL, nacionalidad VARCHAR(50) DEFAULT NULL, codigo_postal VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_50FE07D7E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detalle_pedido (id INT AUTO_INCREMENT NOT NULL, cantidad INT NOT NULL, precio_unidad INT NOT NULL, idPedido INT DEFAULT NULL, idProducto INT DEFAULT NULL, INDEX FK_detalle_pedido_productos (idProducto), INDEX FK_detalle_pedido_pedidos (idPedido), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedidos (id INT AUTO_INCREMENT NOT NULL, fecha DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, estado VARCHAR(255) NOT NULL, direccion VARCHAR(200) NOT NULL, codigo_postal VARCHAR(10) NOT NULL, idCliente INT DEFAULT NULL, INDEX FK_pedidos_clientes (idCliente), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE productos (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, nombre VARCHAR(50) NOT NULL, descripcion VARCHAR(50) NOT NULL, precio INT NOT NULL, peso INT DEFAULT NULL, cantidad INT NOT NULL, activo TINYINT(1) DEFAULT \'1\' NOT NULL, imagen VARCHAR(50) DEFAULT NULL, UNIQUE INDEX url (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (id INT AUTO_INCREMENT NOT NULL, usuario VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(200) NOT NULL, dni VARCHAR(15) NOT NULL, activo TINYINT(1) NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EF687F22265B05D (usuario), UNIQUE INDEX UNIQ_EF687F2E7927C74 (email), UNIQUE INDEX UNIQ_EF687F27F8F253B (dni), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detalle_pedido ADD CONSTRAINT FK_A834F569A7FDBE54 FOREIGN KEY (idPedido) REFERENCES pedidos (id)');
        $this->addSql('ALTER TABLE detalle_pedido ADD CONSTRAINT FK_A834F569F4182C4E FOREIGN KEY (idProducto) REFERENCES productos (id)');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAAE4A5F0D7 FOREIGN KEY (idCliente) REFERENCES clientes (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAAE4A5F0D7');
        $this->addSql('ALTER TABLE detalle_pedido DROP FOREIGN KEY FK_A834F569A7FDBE54');
        $this->addSql('ALTER TABLE detalle_pedido DROP FOREIGN KEY FK_A834F569F4182C4E');
        $this->addSql('DROP TABLE clientes');
        $this->addSql('DROP TABLE detalle_pedido');
        $this->addSql('DROP TABLE pedidos');
        $this->addSql('DROP TABLE productos');
        $this->addSql('DROP TABLE usuarios');
    }
}
