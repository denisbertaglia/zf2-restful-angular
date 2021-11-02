<?php

namespace AgendaApi\Model\Servicos;

use AgendaApi\Model\ArrayInterface;

class Servicos implements ArrayInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $nome;

    /**
     * @var string
     */
    protected $email;


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
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $data
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }


    public function exchangeArray(array $data)
    {
        $this->id = (!empty($data['id'])) ? $data['id']: null;
        $this->descricao = (!empty($data['descricao'])) ? $data['descricao']: null;

    }

    public function getArrayCopy()
    {
        return[
            'id' => $this->getId(),
            'descricao' => $this->getDescricao(),
        ];
    }

}
