<?php

namespace AgendaApi\Controller;

use AgendaApi\Model\Agendamento\AgendamentoTable;
use AgendaApi\Model\Servicos\ServicosTable;
use Zend\View\Model\JsonModel;

class ConsultoresController extends AbstractRestfulJsonController
{
    /** @var $agendaTable AgendamentoTable */
    public  $agendaTable;
    
    /** @var $servicosTable ServicosTable */
    public  $servicosTable;
    
    public function __construct()
    {
    }
    
    public function getList()
    {   
        $agendamento = $this->getAgendaTable();
        $data = $agendamento->fetchAll()->toArray();
        return new JsonModel(
            array(
                'data' => $data,
            )
        );
    }
    
    /**
     * @return AgendamentoTable
     */
    public function getAgendaTable()
    {
        if(!$this->agendaTable){
            $sm = $this->getServiceLocator();
            $this->agendaTable = $sm->get('AgendaTable');
        }
        return $this->agendaTable;
    }
    
    /**
     * @return ServicosTable
     */
    public function getServicosTable()
    {
        if(!$this->servicosTable){
            $sm = $this->getServiceLocator();
            $this->servicosTable = $sm->get('ServicosTable');
        }
        return $this->servicosTable;
    }

}
