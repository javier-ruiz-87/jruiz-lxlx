<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190131153450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tienda_id INTEGER DEFAULT NULL, nombre VARCHAR(50) NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, unidades INTEGER NOT NULL, precio INTEGER NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_A7BB061519BA6D46 ON producto (tienda_id)');
        $this->addSql('CREATE TABLE tienda (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, direccion VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE shopper (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tienda_id INTEGER NOT NULL, nombre VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_26663F5D19BA6D46 ON shopper (tienda_id)');
        $this->addSql('CREATE TABLE pedido_producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pedido_id INTEGER NOT NULL, producto_id INTEGER NOT NULL, unidades INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_DD333C24854653A ON pedido_producto (pedido_id)');
        $this->addSql('CREATE INDEX IDX_DD333C27645698E ON pedido_producto (producto_id)');
        $this->addSql('CREATE TABLE pedido (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cliente_nombre VARCHAR(255) NOT NULL, cliente_email VARCHAR(255) NOT NULL, cliente_telefono INTEGER NOT NULL, cliente_direccion VARCHAR(255) NOT NULL, importe INTEGER NOT NULL, created_at DATETIME NOT NULL, fecha_entrega DATETIME NOT NULL, franja_horaria VARCHAR(100) DEFAULT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE tienda');
        $this->addSql('DROP TABLE shopper');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('DROP TABLE pedido');
    }
}
