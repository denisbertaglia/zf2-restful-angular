<?php

namespace AgendaApi\Model\Agendamento;

use AgendaApi\Model\AbstractModel;
use AgendaApi\Model\ArrayInterface;
use AgendaApi\Model\Consultores\Consultores;
use AgendaApi\Model\Servicos\Servicos;

class Agendamento extends AbstractModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var Consultores
     */
    protected $consultor;

    /**
     * @var Servicos
     */
    protected $servico;

    /**
     * @var string
     */
    protected $emailCliente;

    public function __construct()
    {
        $this->id = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getConsultor()
    {
        return $this->consultor;
    }

    /**
     * @param Consultores $consultor
     */
    public function setConsulor($consultor)
    {
        $this->consultor = $consultor;
    }


    /**
     * {@inheritDoc}
     */
    public function getServico()
    {
        return $this->servico;
    }

    /**
     * @param Servicos $servico
     */
    public function setServico($servico)
    {
        $this->servico = $servico;
    }


    /**
     * {@inheritDoc}
     */
    public function getEmailCliente()
    {
        return $this->emailCliente;
    }

    /**
     * @param string $emailCliente
     */
    public function setEmailCliente($emailCliente)
    {
        $this->emailCliente = $emailCliente;
    }

    public function exchangeArray(array $data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->data = (!empty($data['data'])) ? $data['data'] : null;
        $this->consultor = (!empty($data['consultor'])) ? $data['consultor'] : null;
        $this->servico = (!empty($data['servico'])) ? $data['servico'] : null;
        $this->emailCliente = (!empty($data['email_cliente'])) ? $data['email_cliente'] : null;

        $consultor = new Consultores();
        $consultorId = (!empty($data['Consultorid'])) ? $data['Consultorid'] : 0;
        $consultorNome = (!empty($data['ConsultorNome'])) ? $data['ConsultorNome'] : null;
        $consultorEmail = (!empty($data['ConsultorEmail'])) ? $data['ConsultorEmail'] : null;
        $consultor->setId($consultorId);
        $consultor->setNome($consultorNome);
        $consultor->setEmail($consultorEmail);
        
        $servico = new Servicos();
        $servicoId = (!empty($data['ServicoId'])) ? $data['ServicoId'] : 0;
        $servicoDescricao = (!empty($data['ServicoDescricao'])) ? $data['ServicoDescricao'] : '';
        $servico->setId($servicoId);
        $servico->setDescricao($servicoDescricao);

        $this->consultor = $consultor;
        $this->servico = $servico;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'data' => $this->getData(),
            'consultor' => $this->getConsultor()->toArray(),
            'servico' => $this->getServico()->toArray(),
            'email_cliente' => $this->getEmailCliente(),
        ];
    }
}
