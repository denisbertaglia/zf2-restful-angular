<?php

namespace AgendaApi\Service;

use AgendaApi\Model\AgendamentoInterface;

interface AgendamentoServiceInterface
{
    /**
     * Deve retornar um array agendamento
     * implementando \AgendaApi\Model\AgendamentoInterface
     *
     * @return array|AgendamentoInterface[]
     */
    public function findAllAgendamentos();

    /**
     * Deve retornar um agendamento
     *
     * @param  int $id Identificador do agendamento que ve ser retornado
     * @return AgendamentoInterface
     */
    public function findAgendamento($id);
}
