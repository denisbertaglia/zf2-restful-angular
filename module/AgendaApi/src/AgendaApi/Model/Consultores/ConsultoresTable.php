<?php

namespace AgendaApi\Model\Consultores;

use AgendaApi\Model\Consultores\Consultores;
use AgendaApi\Model\Servicos\Servicos;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

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
     * @return Select
     */
    private function selectConsultor()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            [
                'id',
                'nome',
                'email',
            ]
        );
        $sqlSelect->join(
            'rel_servico_consultor',
            'rel_servico_consultor.id_consultor = Consultores.id',
            array()
        );
        return $sqlSelect;
    }

    /**
     * @return array
     */
    public function consultoresParaOServico(Servicos $servico)
    {
        $sqlSelect = $this->selectConsultor();
        $servicoId = $servico->getId();
        $sqlSelect->where->equalTo('rel_servico_consultor.id_servico', $servicoId);
        /** @var ResultSet*/
        $resultSet = $this->tableGateway
            ->selectWith($sqlSelect);

        return $resultSet->toArray();
    }

    /**
     * @return bool
     */
    public function consultorPodeAgendarOServico(Servicos $servico, Consultores $consultor)
    {
        $sqlSelect = $this->selectConsultor();
        $servicoId = $servico->getId();
        $consultorId = $consultor->getId();
        $sqlSelect
            ->where->equalTo('rel_servico_consultor.id_consultor', $consultorId)
            ->where->equalTo('rel_servico_consultor.id_servico', $servicoId);
        $resultSet = $this->tableGateway
            ->selectWith($sqlSelect)
            ->count();

        return ($resultSet >= 1);
    }
}
