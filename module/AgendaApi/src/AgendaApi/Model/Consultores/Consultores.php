<?php

namespace AgendaApi\Model\Consultores;

use AgendaApi\Model\AbstractModel;

class Consultores  extends AbstractModel 
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
    public function getNome()
    {
        return $this->nome;
    }
    
    public function setNome( $nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @param string $data
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail( $email)
    {
        $this->email = $email;

        return $this;
    }

    public function exchangeArray(array $data)
    {
        $this->id = (!empty($data['id'])) ? $data['id']: null;
        $this->nome = (!empty($data['nome'])) ? $data['nome']: null;
        $this->email = (!empty($data['email'])) ? $data['email']: null;
    }

    public function toArray()
    {
        
        return array(
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'email' =>$this->getEmail()
        );
    }


}
