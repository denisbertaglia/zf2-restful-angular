<?php

namespace AgendaApi\Model;

class Agendamento implements AgendamentoInterface, ArrayInterface
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
     * @var string
     */
    protected $consultor;

    /**
     * @var string
     */
    protected $servico;

    /**
     * @var string
     */
    protected $emailCliente;

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
     * @param string $consultor
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
     * @param string $servico
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
        $this->id = (!empty($data['id'])) ? $data['id']: null;
        $this->data = (!empty($data['data'])) ? $data['data']: null;
        $this->consultor = (!empty($data['consultor'])) ? $data['consultor']: null;
        $this->servico = (!empty($data['servico'])) ? $data['servico']: null;
        $this->emailCliente = (!empty($data['emailCliente'])) ? $data['emailCliente']: null;

    }

    public function getArrayCopy()
    {
        return[
            'id' => $this->id,
            'data' => $this->data,
            'consultor' => $this->consultor,
            'servico' => $this->servico,
            'email_cliente' => $this->emailCliente,
        ];
    }

}
