<?php

namespace AgendaApi\Model\Consultores;

use AgendaApi\Model\Consultores\Consultores;
use AgendaApi\Model\Servicos\Servicos;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\TableGateway\TableGateway;

class ConsultoresTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return ResultSet
     */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    /**
     * @return bool
     */
    public function consultorPodeAgendarOServico(Servicos $servico, Consultores $consultor)
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            [
                'id',
                'nome',
            ]
        );
        $sqlSelect->join(
            'rel_servico_consultor',
            'rel_servico_consultor.id_consultor = Consultores.id',
            array()
        );
        $servicoId = $servico->getId();
        $consultorId = $consultor->getId();
        $sqlSelect
            ->where->equalTo('rel_servico_consultor.id_consultor', $consultorId)
            ->where->equalTo('rel_servico_consultor.id_servico', $servicoId);
        $resultSet = $this->tableGateway
            ->selectWith($sqlSelect)
            ->count();

        return ($resultSet>=1);
    }
}
