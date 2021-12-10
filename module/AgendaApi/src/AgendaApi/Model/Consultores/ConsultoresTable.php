<?php

namespace AgendaApi\Model\Consultores;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use AgendaApi\Model\Servicos\Servicos;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\ArrayUtils;
use AgendaApi\Model\Consultores\Consultores;
use AgendaApi\Model\ModelUtil;

class ConsultoresTable
{
    protected $tableGateway;
    protected $adapter;

    public function __construct(TableGateway $tableGateway, Adapter $adapter)
    {
        $this->tableGateway = $tableGateway;
        $this->adapter = $adapter;
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('Consultores');
        $select->join(
            'rel_servico_consultor',
            'rel_servico_consultor.id_consultor = Consultores.id',
            array()
        );
        $select->join(
            'Servicos',
            'rel_servico_consultor.id_servico = Servicos.id',
            array(
                'servico_id' => 'id',
                'servico_descricao' => 'descricao',
            )
        );
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resutlsArray = ArrayUtils::iteratorToArray($results);
        $data = $this->arrayMapper($resutlsArray);

        return $data;
    }

    /**
     * @return Select
     */
    private function selectConsultor()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(
            [
                'id',
                'nome',
                'email',
            ]
        );
        $sqlSelect->join(
            'rel_servico_consultor',
            'rel_servico_consultor.id_consultor = Consultores.id',
            array()
        );
        return $sqlSelect;
    }

    /**
     * @return array
     */
    public function consultoresParaOServico(Servicos $servico)
    {
        $sqlSelect = $this->selectConsultor();
        $servicoId = $servico->getId();
        $sqlSelect->where->equalTo('rel_servico_consultor.id_servico', $servicoId);
        /** @var ResultSet*/
        $resultSet = $this->tableGateway
            ->selectWith($sqlSelect);

        return $resultSet->toArray();
    }

    /**
     * @return bool
     */
    public function consultorPodeAgendarOServico(Servicos $servico, Consultores $consultor)
    {
        $sqlSelect = $this->selectConsultor();
        $servicoId = $servico->getId();
        $consultorId = $consultor->getId();
        $sqlSelect
            ->where->equalTo('rel_servico_consultor.id_consultor', $consultorId)
            ->where->equalTo('rel_servico_consultor.id_servico', $servicoId);
        $resultSet = $this->tableGateway
            ->selectWith($sqlSelect)
            ->count();

        return ($resultSet >= 1);
    }


    private function arrayMapper(array $resultsConsultores)
    {
        /** @var array[] */
        $consultores = [];
        foreach ($resultsConsultores as $consultoData) {
            $consultor = ModelUtil::findByIdInArray($consultores,$consultoData['id']);
            if($consultor === null){
                $consultor = new Consultores();
                $consultor->setId($consultoData['id']);
                $consultor->setNome($consultoData['nome']);
                $consultor = $consultor->toArray();
                $servicos = $consultor['servicos'];
            }else{
                $servicos = $consultor['servicos'];
            }
            
            $servico = ModelUtil::findByIdInArray($servicos,$consultoData['servico_id']);
            if($servico === null){
                $servico = new Servicos();
                $servico->exchangeArray([
                    'id'=> $consultoData['servico_id'],
                    'descricao'=> $consultoData['servico_descricao'],
                ]);
                $consultor['servicos'][] = $servico->toArray();
            }
            $consultores[$consultoData['id']] = $consultor;
        }
        
        return  array_values($consultores);
    }
}
