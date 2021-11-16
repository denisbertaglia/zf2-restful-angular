<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20211116204436 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('Servicos');
        $table->addColumn('id', 'integer');
        $table->addColumn('descricao', 'string', [
            'length' => 255,
            'notnull' => true
        ]);
        $table->setPrimaryKey(array('id'));
    }

    public function postUp(Schema $schema)
    {
        $table = 'Servicos';
        $this->connection->insert(
            $table,
            [
                'id' => 1,
                'descricao' => "Desenvolvimento de Landing Page"
            ]
        );
        $this->connection->insert(
            $table,
            [
                'id' => 2,
                'descricao' => "Customização de CSS"
            ]
        );
        $this->connection->insert(
            $table,
            [
                'id' => 3,
                'descricao' => "Instalação do Wordpress"
            ]
        );
        $this->connection->insert(
            $table,
            [
                'id' => 4,
                'descricao' => "Desenvolvimento de Plugin"
            ]
        );
        $this->connection->insert(
            $table,
            [
                'id' => 5,
                'descricao' => "Desenvolvimento de Tema"
            ]
        );
        parent::postUp($schema);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('Servicos');
    }
}
