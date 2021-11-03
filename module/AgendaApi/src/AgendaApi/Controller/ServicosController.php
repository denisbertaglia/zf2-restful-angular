<?php

namespace AgendaApi\Controller;

use AgendaApi\Model\Servicos\ServicosTable;
use Zend\Http\Headers;
use Zend\View\Model\JsonModel;

class ServicosController extends AbstractRestfulJsonController
{
    /** @var $servicosTable ServicosTable */
    public  $servicosTable;
    
    public function __construct()
    {

    }
    
    public function getList()
    {   
        $agendamento = $this->getServicosTable();
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
