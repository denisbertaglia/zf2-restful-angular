<?php

namespace AgendaApi\Service\Agendamento;

use AgendaApi\Model\Agendamento\Agendamento;
use AgendaApi\Model\Agendamento\AgendamentoFiltro;
use AgendaApi\Model\Agendamento\AgendamentoTable;
use AgendaApi\Model\Consultores\ConsultoresTable;

class AgendamentoService 
{
    /** @var AgendamentoTable $agendaTable  */
    public  $agendaTable;
    
    /** @var ConsultoresTable $servicosTable  */
    public  $consultoresTable;

    public function __construct(AgendamentoTable $agendaTable, ConsultoresTable $consultoresTable)
    {
        $this->agendaTable= $agendaTable;
        $this->consultoresTable= $consultoresTable;
    }

    public function agendar(Agendamento $agendamento)
    {
        $consultor = $agendamento->getConsultor();
        $servico = $agendamento->getServico();
        $servicoAutorizado = $this->consultoresTable->consultorPodeAgendarOServico($servico, $consultor);
        $diaOcupado = $this->agendaTable->temAgendamentoDoConsultorNoMesmoDia($agendamento);
        
        if($servicoAutorizado && !$diaOcupado ){
            $this->agendaTable->saveAgendamento($agendamento);
        }
    }
    /**
     * @return array
     */
    public function verAgenda(AgendamentoFiltro $filtro)
    {
        return $this->agendaTable->getAgendamentoPor($filtro)->toArray();
    }
}
