<?php

namespace AgendaApi\Service;

use AgendaApi\Model\Agendamento;

class AgendamentoService implements AgendamentoServiceInterface
{
    protected  $data;
    public function __construct()
    {
        $this->data = array(
            array(
                'id'    => 1,
                'data' => '2000-07-01T00:00:00+00:00',
                'consultor'  => 2,
                'servico'  => 1,
                'emailCliente'  => 'testes@example.com',
            ),
            array(
                'id'    => 2,
                'data' => '2000-07-01T00:00:00+00:00',
                'consultor'  => 2,
                'servico'  => 1,
                'emailCliente'  => 'testes@example.com',
            ),
            array(
                'id'    => 3,
                'data' => '2000-07-01T00:00:00+00:00',
                'consultor'  => 2,
                'servico'  => 1,
                'emailCliente'  => 'testes@example.com',
            ),
            array(
                'id'    => 4,
                'data' => '2000-07-01T00:00:00+00:00',
                'consultor'  => 2,
                'servico'  => 1,
                'emailCliente'  => 'testes@example.com',
            ),
            array(
                'id'    => 5,
                'data' => '2000-07-01T00:00:00+00:00',
                'consultor'  => 2,
                'servico'  => 1,
                'emailCliente'  => 'testes@example.com',
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function findAllAgendamentos()
    {
        $agendamentos = array();

        foreach ($this->data as $index => $post) {
            $agendamentos[] = $this->findAgendamento($index);
        }
        
        return $agendamentos;
    }

    /**
     * {@inheritDoc}
     */
    public function findAgendamento($id)
    {
        $agendamentoData = $this->data[$id];

        $model = new Agendamento();
        $model->setId($agendamentoData['id']);
        $model->setData($agendamentoData['data']);
        $model->setConsulor($agendamentoData['consultor']);
        $model->setServico($agendamentoData['servico']);
        $model->setEmailCliente($agendamentoData['emailCliente']);

        return $model;
    }
}
