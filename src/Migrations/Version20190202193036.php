<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190202193036 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_A7BB061519BA6D46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__producto AS SELECT id, tienda_id, nombre, descripcion, unidades, precio, created_at FROM producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('CREATE TABLE producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tienda_id INTEGER DEFAULT NULL, nombre VARCHAR(50) NOT NULL COLLATE BINARY, descripcion VARCHAR(255) DEFAULT NULL COLLATE BINARY, unidades INTEGER NOT NULL, precio INTEGER NOT NULL, created_at DATETIME NOT NULL, CONSTRAINT FK_A7BB061519BA6D46 FOREIGN KEY (tienda_id) REFERENCES tienda (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO producto (id, tienda_id, nombre, descripcion, unidades, precio, created_at) SELECT id, tienda_id, nombre, descripcion, unidades, precio, created_at FROM __temp__producto');
        $this->addSql('DROP TABLE __temp__producto');
        $this->addSql('CREATE INDEX IDX_A7BB061519BA6D46 ON producto (tienda_id)');
        $this->addSql('DROP INDEX IDX_26663F5D19BA6D46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__shopper AS SELECT id, tienda_id, nombre, created_at FROM shopper');
        $this->addSql('DROP TABLE shopper');
        $this->addSql('CREATE TABLE shopper (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tienda_id INTEGER NOT NULL, nombre VARCHAR(50) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, CONSTRAINT FK_26663F5D19BA6D46 FOREIGN KEY (tienda_id) REFERENCES tienda (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO shopper (id, tienda_id, nombre, created_at) SELECT id, tienda_id, nombre, created_at FROM __temp__shopper');
        $this->addSql('DROP TABLE __temp__shopper');
        $this->addSql('CREATE INDEX IDX_26663F5D19BA6D46 ON shopper (tienda_id)');
        $this->addSql('DROP INDEX IDX_DD333C27645698E');
        $this->addSql('DROP INDEX IDX_DD333C24854653A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido_producto AS SELECT id, pedido_id, producto_id, unidades FROM pedido_producto');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('CREATE TABLE pedido_producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pedido_id INTEGER NOT NULL, producto_id INTEGER NOT NULL, unidades INTEGER NOT NULL, CONSTRAINT FK_DD333C24854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DD333C27645698E FOREIGN KEY (producto_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO pedido_producto (id, pedido_id, producto_id, unidades) SELECT id, pedido_id, producto_id, unidades FROM __temp__pedido_producto');
        $this->addSql('DROP TABLE __temp__pedido_producto');
        $this->addSql('CREATE INDEX IDX_DD333C27645698E ON pedido_producto (producto_id)');
        $this->addSql('CREATE INDEX IDX_DD333C24854653A ON pedido_producto (pedido_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_DD333C24854653A');
        $this->addSql('DROP INDEX IDX_DD333C27645698E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido_producto AS SELECT id, pedido_id, producto_id, unidades FROM pedido_producto');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('CREATE TABLE pedido_producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pedido_id INTEGER NOT NULL, producto_id INTEGER NOT NULL, unidades INTEGER NOT NULL)');
        $this->addSql('INSERT INTO pedido_producto (id, pedido_id, producto_id, unidades) SELECT id, pedido_id, producto_id, unidades FROM __temp__pedido_producto');
        $this->addSql('DROP TABLE __temp__pedido_producto');
        $this->addSql('CREATE INDEX IDX_DD333C24854653A ON pedido_producto (pedido_id)');
        $this->addSql('CREATE INDEX IDX_DD333C27645698E ON pedido_producto (producto_id)');
        $this->addSql('DROP INDEX IDX_A7BB061519BA6D46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__producto AS SELECT id, tienda_id, nombre, descripcion, unidades, precio, created_at FROM producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('CREATE TABLE producto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tienda_id INTEGER DEFAULT NULL, nombre VARCHAR(50) NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, unidades INTEGER NOT NULL, precio INTEGER NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO producto (id, tienda_id, nombre, descripcion, unidades, precio, created_at) SELECT id, tienda_id, nombre, descripcion, unidades, precio, created_at FROM __temp__producto');
        $this->addSql('DROP TABLE __temp__producto');
        $this->addSql('CREATE INDEX IDX_A7BB061519BA6D46 ON producto (tienda_id)');
        $this->addSql('DROP INDEX IDX_26663F5D19BA6D46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__shopper AS SELECT id, tienda_id, nombre, created_at FROM shopper');
        $this->addSql('DROP TABLE shopper');
        $this->addSql('CREATE TABLE shopper (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tienda_id INTEGER NOT NULL, nombre VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO shopper (id, tienda_id, nombre, created_at) SELECT id, tienda_id, nombre, created_at FROM __temp__shopper');
        $this->addSql('DROP TABLE __temp__shopper');
        $this->addSql('CREATE INDEX IDX_26663F5D19BA6D46 ON shopper (tienda_id)');
    }
}
