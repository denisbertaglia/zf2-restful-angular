<?php

namespace AgendaApi\Service\Agendamento;

use AgendaApi\Model\Agendamento\Agendamento;
use AgendaApi\Model\Agendamento\AgendamentoFiltro;
use AgendaApi\Model\Agendamento\AgendamentoTable;
use AgendaApi\Model\Consultores\ConsultoresTable;
use DomainException;

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

    /**
     * @throws DomainException Codigo 0 se o consultor não esta habilitado para o serviço
     * @throws DomainException Codigo 1 se o consultor não tem o dia livre
     */
    public function agendar(Agendamento $agendamento)
    {
        $consultor = $agendamento->getConsultor();
        $servico = $agendamento->getServico();
        $servicoAutorizado = $this->consultoresTable->consultorPodeAgendarOServico($servico, $consultor);
        $diaOcupado = $this->agendaTable->temAgendamentoDoConsultorNoMesmoDia($agendamento);
        
        if($servicoAutorizado && !$diaOcupado ){
            $this->agendaTable->saveAgendamento($agendamento);
        }
        if(!$servicoAutorizado){
            throw new DomainException("Este consultor não esta habilitado para este serviço.", 0);
        }

        if($diaOcupado){
            throw new DomainException("Este consultor não tem este dia livre.", 1);
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
