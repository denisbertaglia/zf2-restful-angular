<?php

namespace AgendaApi\Model\Agendamento;

use AgendaApi\Model\Agendamento\Agendamento;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class AgendamentoTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    /**
     * @return Select
     */
    private function selectAgendamento()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            [
                'id',
                'data',
                'email_cliente'
            ]
        );
        $sqlSelect->join(
            'Consultores',
            'Agendamento.consultor = Consultores.id',
            array(
                'Consultorid' =>'id',
                'ConsultorNome' =>'nome',
                'ConsultorEmail' =>'email',
            )
        );
        $sqlSelect->join(
            'Servicos',
            'Agendamento.servico = Servicos.id',
            array(
                'ServicoId' =>'id',
                'ServicoDescricao' =>'descricao',
            )
        );
        return $sqlSelect;
    }

    /**
     * @return bool
     */
    public function temAgendamentoDoConsultorNoMesmoDia(Agendamento $agendamento)
    {
        
        $sqlSelect =  $this->selectAgendamento();
        
        $sqlSelect->where
            ->expression("strftime('%Y-%m-%d',Agendamento.data) = strftime('%Y-%m-%d', ?)",$agendamento->getData());
        
        $consultor = $agendamento->getConsultor();
        $sqlSelect->where->equalTo('Consultores.id',$consultor->getId());
 
        
        $resultSet = $this->tableGateway
                    ->selectWith($sqlSelect)
                    ->count();
        
        return ($resultSet>=1);
    }

    /**
     * @return ResultSet
     */
    public function getAgendamentos()
    {
        $sqlSelect = $this->selectAgendamento();
        $resultSet = $this->tableGateway->selectWith($sqlSelect);
        return $resultSet;
    }

    public function getAgendamento($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    /**
     * @return ResultSet
     */
    public function getAgendamentoPor(AgendamentoFiltro $filtro)
    {
        $sqlSelect = $this->selectAgendamento();
        
        $consultor = $filtro->getConsultor();
        if(!is_null($consultor)){
            $sqlSelect->where->equalTo('Consultores.id',$consultor->getId());
        }
        
        $data = $filtro->getData();
        if(!is_null($data)){
            $sqlSelect->where
            ->expression("strftime('%Y-%m-%d',Agendamento.data) = strftime('%Y-%m-%d', ?)",$data);
        }
        
        $servico = $filtro->getServico();
        if(!is_null($servico)){
            $sqlSelect->where->equalTo('Servicos.id',$servico->getId());
        }
        
        $resultSet = $this->tableGateway->selectWith($sqlSelect);
 
        return $resultSet;
    }
    /**
     * 
     */
    public function saveAgendamento(Agendamento $agendamento)
    {
        $data = array(
            'data' => $agendamento->getData(),
            'consultor' => $agendamento->getConsultor()->getId(),
            'servico' => $agendamento->getServico()->getId(),
            'email_cliente' => $agendamento->getEmailCliente(),
        );

        $id = (int) $agendamento->getId();
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAgendamento($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Agendamento não existe');
            }
        }
    }

}
