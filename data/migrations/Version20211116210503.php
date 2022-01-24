<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20211116210503 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('rel_servico_consultor');
        $table->addColumn('id_servico', 'integer');
        $table->addColumn('id_consultor', 'integer');
    }
    public function postUp(Schema $schema)
    {
        $table = 'rel_servico_consultor';
        $this->connection->insert(
            $table,
            [
                'id_consultor' => 1,
                'id_servico' => 4,
            ]
        );
        $this->connection->insert(
            $table,
            [
                'id_consultor' => 1,
                'id_servico' => 5,
            ]
        );
        $this->connection->insert(
            $table,
            [
                'id_consultor' => 2,
                'id_servico' => 1,
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
        $schema->dropTable('rel_servico_consultor');
    }
}
