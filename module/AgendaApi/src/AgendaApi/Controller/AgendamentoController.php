<?php

namespace AgendaApi\Controller;

use AgendaApi\Model\Agendamento\Agendamento;
use AgendaApi\Model\Agendamento\AgendamentoFiltro;
use AgendaApi\Model\Consultores\Consultores;
use AgendaApi\Model\Servicos\Servicos;
use AgendaApi\Service\Agendamento\AgendamentoService;
use Zend\View\Model\JsonModel;

class AgendamentoController extends AbstractRestfulJsonController
{

    /** @var AgendamentoService $agendamentoService  */
    public  $agendamentoService;
    
    public function __construct()
    {

    }
    
    public function getList()
    {   
        $params = $this->params()->fromQuery();
        
        $filtro = new AgendamentoFiltro();
        if(isset($params['consultorId'])){
            $consultor = new Consultores();
            $consultor->setId($params['consultorId']);
            $filtro->setConsultor($consultor);
        }
        
        if(isset($params['servicoId'])){
            $servico = new Servicos();
            $servico->setId($params['servicoId']);
            $filtro->setServico($servico);
        }
        
        if(isset($params['data'])){
            $filtro->setData($params['data']);
        }

        $agendamentoService = $this->getAgendamentoService();
        $data = $agendamentoService->verAgenda($filtro);
        return new JsonModel(
            array(
                'data' => $data,
            )
        );
    }

    public function create($data)
    {   // Action used for POST requests
        
        $agendamento = new Agendamento();
        $agendamento->setId($data['id']);
        $agendamento->setData($data['data']);
        $agendamento->setEmailCliente($data['email_cliente']);

        $consultor = new Consultores();
        $consultor->setId($data['consultor']['id']);
        $agendamento->setConsulor($consultor);

        $service = new Servicos();
        $service->setId($data['servico']['id']);
        $agendamento->setServico($service);
        
        $agendamentoService = $this->getAgendamentoService();
        $agendamentoService->agendar($agendamento);
 
        $data = [];

        return new JsonModel(array('data' => $data));
    }
    
    /**
     * @return AgendamentoService
     */
    public function getAgendamentoService()
    {
        if(!$this->agendamentoService){
            $sm = $this->getServiceLocator();
            $this->agendamentoService = $sm->get('AgendamentoService');
        }
        return $this->agendamentoService;
    }

}
