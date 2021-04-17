<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210416230500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clientes CHANGE dni dni VARCHAR(15) NOT NULL, CHANGE codigo_postal codigo_postal VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE detalle_pedido CHANGE idPedido idPedido INT DEFAULT NULL, CHANGE idProducto idProducto INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pedidos CHANGE codigo_postal codigo_postal VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE productos CHANGE url url VARCHAR(255) NOT NULL, CHANGE descripcion descripcion VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE usuarios ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clientes CHANGE dni dni VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE codigo_postal codigo_postal VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE detalle_pedido CHANGE idPedido idPedido INT NOT NULL, CHANGE idProducto idProducto INT NOT NULL');
        $this->addSql('ALTER TABLE pedidos CHANGE codigo_postal codigo_postal VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE productos CHANGE url url VARCHAR(250) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE descripcion descripcion MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE usuarios DROP is_verified');
    }
}
