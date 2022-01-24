<?php

namespace AgendaApi\Model\Servicos;

use AgendaApi\Model\AbstractModel;
use AgendaApi\Model\IdModel;

class Servicos  extends AbstractModel implements IdModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $descricao;



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

    public function toArray()
    {
        
        return array(
            'id' => $this->getId(),
            'descricao' => $this->getDescricao(),
        );
    }

}
