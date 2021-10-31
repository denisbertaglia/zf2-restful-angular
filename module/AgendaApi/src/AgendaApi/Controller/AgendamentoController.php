<?php

namespace AgendaApi\Controller;

use AgendaApi\Model\Agendamento;
use AgendaApi\Service\AgendamentoServiceInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class AgendamentoController extends AbstractRestfulController
{
    /**
     * @var \AgendaApi\Service\AgendamentoServiceInterface
     */
    protected $agendamentoService;

    //public function __construct()
    public function __construct(AgendamentoServiceInterface $agendamentoService)
    {
       $this->agendamentoService = $agendamentoService;
    }
    
    public function getList()
    {   
        $data = $this->agendamentoService->findAllAgendamentos();
        $data = array_map(function (Agendamento $agendamento){
            return $agendamento->toArray();
        },$data);
        
        return new JsonModel(
            array(
                'data' => $data
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
}
