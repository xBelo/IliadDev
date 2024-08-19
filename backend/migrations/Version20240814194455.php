<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240814194455 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "products_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        // This migration creates the order table
        $this->addSql('CREATE TABLE "order" (
            id INT NOT NULL, 
            name VARCHAR(255) NOT NULL, 
            description VARCHAR(255) DEFAULT NULL, 
            date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
            PRIMARY KEY(id))');

        // This migration creates the products table
        $this->addSql('CREATE TABLE "products" (
            id INT NOT NULL,
            name VARCHAR(255) NOT NULL, 
            price DOUBLE PRECISION NOT NULL, 
            PRIMARY KEY(id))');

        // This migration creates the many-to-many relationship table
        $this->addSql('CREATE TABLE "order_products" (
            order_id INT NOT NULL, 
            products_id INT NOT NULL
        )');
    }

    public function down(Schema $schema) : void
    {
        // This migration drops the many-to-many relationship table
        $this->addSql('DROP TABLE order_products');

        // This migration drops the order table
        $this->addSql('DROP TABLE order');

        // This migration drops the products table
        $this->addSql('DROP TABLE products');
    }
}