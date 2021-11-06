<?php

namespace AgendaApi\Controller;

use AgendaApi\Model\Consultores\ConsultoresTable;
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
        $consultores = $this->getConsuloresTable();
        $data = $consultores->fetchAll()->toArray();
        return new JsonModel(
            array(
                'data' => $data,
            )
        );
    }
    
    /**
     * @return ConsultoresTable
     */
    public function getConsuloresTable()
    {
        if(!$this->agendaTable){
            $sm = $this->getServiceLocator();
            $this->agendaTable = $sm->get('ConsultoresTable');
        }
        return $this->agendaTable;
    }

}
