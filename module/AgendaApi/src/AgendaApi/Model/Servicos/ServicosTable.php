<?php

namespace AgendaApi\Model\Servicos;

use AgendaApi\Model\Consultores\Consultores;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class ServicosTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return Select
     */
    public function selectService()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            [
                'id',
                'descricao',
            ]
        );
        $sqlSelect->join(
            'rel_servico_consultor',
            'rel_servico_consultor.id_servico = Servicos.id',
            array()
        );
        return $sqlSelect;
    }

    /**
     * @return array
     */
    public function servicosHabilitadosParaConsultor(Consultores $consultor)
    {
        $sqlSelect = $this->selectService();
        $consultorId = $consultor->getId();
        $sqlSelect->where->equalTo('rel_servico_consultor.id_consultor', $consultorId);
        /** @var ResultSet*/
        $resultSet = $this->tableGateway
            ->selectWith($sqlSelect);
        return $resultSet->toArray();
    }

    /**
     * @return ResultSet
     */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

}
