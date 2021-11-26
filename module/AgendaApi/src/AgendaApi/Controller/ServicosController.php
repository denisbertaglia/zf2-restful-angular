<?php

namespace AgendaApi\Controller;

use AgendaApi\Model\Consultores\Consultores;
use AgendaApi\Model\Servicos\ServicosTable;
use Zend\View\Model\JsonModel;

class ServicosController extends AbstractRestfulJsonController
{
    /** @var ServicosTable $servicosTable */
    public  $servicosTable;
    
    public function __construct() {}
    
    public function getList()
    {   
        $servicoTable = $this->getServicosTable();
        $params = $this->params()->fromQuery();
        $data = [];

        if (count($params) == 0) {
            $data = $servicoTable->fetchAll()->toArray();
        }

        if (isset($params['consultorId'])) {
            $consultor = new Consultores();
            $consultor->setId($params['consultorId']);
            $data = $servicoTable->servicosHabilitadosParaConsultor($consultor);
        }

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
