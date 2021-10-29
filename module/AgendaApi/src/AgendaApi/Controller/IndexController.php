<?php
namespace AgendaApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;


class IndexController extends AbstractRestfulController
{
    public function index()
    {
        return new JsonModel(array('data' => "Bem-vindo ao a API de agendamento."));
    }
}