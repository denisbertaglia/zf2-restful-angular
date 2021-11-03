<?php

namespace AgendaApi\Controller;

use AgendaApi\Model\Agendamento\AgendamentoTable;
use AgendaApi\Model\Servicos\ServicosTable;
use Zend\Http\Headers;
use Zend\View\Model\JsonModel;

class AgendamentoController extends AbstractRestfulJsonController
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

    public function get($id)
    {   // Action used for GET requests with resource Id
        return new JsonModel(array("data" => array('id' => 2, 'name' => 'Coda', 'band' => 'Led Zeppelin')));
    }

    public function create($data)
    {   // Action used for POST requests
        return new JsonModel(array('data' => array('id' => 3, 'name' => 'New Album', 'band' => 'New Band')));
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        return new JsonModel(array('data' => array('id' => 3, 'name' => 'Updated Album', 'band' => 'Updated Band')));
    }

    public function delete($id)
    {   // Action used for DELETE requests
        return new JsonModel(array('data' => 'album id 3 deleted'));
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
