<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20211116210608 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('Agendamento');
        $table->addColumn('id', 'integer');
        $table->addColumn('consultor', 'integer', [
            'notnull' => true
        ]);
        $table->addColumn('servico', 'integer', [
            'notnull' => true
        ]);
        $table->addColumn('data', 'string', [
            'length' => 255,
            'notnull' => true
        ]);
        $table->addColumn('email_cliente', 'string', [
            'length' => 255,
            'notnull' => true
        ]);
        $table->setPrimaryKey(array('id'));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('Agendamento');

    }
}
