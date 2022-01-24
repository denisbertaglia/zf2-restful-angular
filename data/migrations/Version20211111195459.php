<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20211111195459 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('Consultores');
        $table->addColumn('id', 'integer');
        $table->addColumn('nome', 'string', [
            'length' => 255,
            'notnull' => true
        ]);
        $table->addColumn('email', 'string', [
            'length' => 255,
            'notnull' => true
        ]);
        $table->setPrimaryKey(array('id'));
    }

    public function postUp(Schema $schema)
    {
        $table = 'Consultores';
        $this->connection->insert(
            $table,
            [
                'id' => 1,
                'nome' => "Aline Santos Ribeiro",
                'email' => "aline.santos@gmail.com",
            ]
        );
        $this->connection->insert(
            $table,
            [
                'id' => 2,
                'nome' => "Carolina de Oliveira",
                'email' => "carol.oliv@gmail.com",
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
        $schema->dropTable('Consultores');
    }
}
