<?php

namespace AgendaApi\Controller;

use AgendaApi\Model\Consultores\ConsultoresTable;
use AgendaApi\Model\Servicos\Servicos;
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
        $params = $this->params()->fromQuery();
        $data = [];

        if (count($params) == 0) {
            $data = $consultores->fetchAll()->toArray();
            return new JsonModel(
                array(
                    'data' => $data,
                )
            );
        }
        if (isset($params['servicoId'])) {
            $servico = new Servicos();
            $servico->setId($params['servicoId']);
            $data = $consultores->consultoresParaOServico($servico);
        }
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
        if (!$this->agendaTable) {
            $sm = $this->getServiceLocator();
            $this->agendaTable = $sm->get('ConsultoresTable');
        }
        return $this->agendaTable;
    }
}
