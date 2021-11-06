<?php

namespace AgendaApi\Model\Agendamento;

use AgendaApi\Model\Consultores\Consultores;
use AgendaApi\Model\Servicos\Servicos;

class AgendamentoFiltro 
{
    private $data;
    private $servico;
    private $consultor;

    public function __construct($data = null, $servico = null, $consultor = null)
    {
        $this->setData($data);
        $this->setServico($servico);
        $this->setConsultor($consultor);
    }

    /**
     * Get the value of data
     * @return string
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of servico
     * @return Servicos | null
     */ 
    public function getServico()
    {
        return $this->servico;
    }

    /**
     * Set the value of servico
     *
     * @return  self
     */ 
    public function setServico($servico)
    {
        $this->servico = $servico;

        return $this;
    }

    /**
     * Get the value of consultor
     * @return Consultores | null
     */ 
    public function getConsultor()
    {
        return $this->consultor;
    }

    /**
     * Set the value of consultor
     *
     * @return  self
     */ 
    public function setConsultor($consultor)
    {
        $this->consultor = $consultor;

        return $this;
    }
}
