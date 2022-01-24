<?php

namespace AgendaApi;

use AgendaApi\Model\Agendamento\Agendamento;
use AgendaApi\Model\Agendamento\AgendamentoTable;
use AgendaApi\Model\Consultores\Consultores;
use AgendaApi\Model\Consultores\ConsultoresTable;
use AgendaApi\Model\Servicos\Servicos;
use AgendaApi\Model\Servicos\ServicosTable;
use AgendaApi\Service\Agendamento\AgendamentoService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), 0);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'onRenderError'), 0);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onDispatchError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function onRenderError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function getJsonModelError($e)
    {
        $error = $e->getError();
        if (!$error) {
            return;
        }

        $exception = $e->getParam('exception');
        $exceptionJson = array();
        if ($exception) {
            $exceptionJson = array(
                'class' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
                'stacktrace' => $exception->getTraceAsString()
            );
        }

        $errorJson = array(
            'message'   => 'An error occurred during execution; please try again later.',
            'error'     => $error,
            'exception' => $exceptionJson,
            'code' => -1,
        );
        if ($error == 'error-router-no-match') {
            $errorJson['message'] = 'Resource not found.';
        }

        $model = new JsonModel(array('errors' => array($errorJson)));

        $e->setResult($model);
        $e->getResponse()->setStatusCode(500);

        return $model;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AgendaTable' =>  function ($sm) {
                    $tableGateway = $sm->get('AgendaTableGateway');
                    $table = new AgendamentoTable($tableGateway);
                    return $table;
                },
                'AgendaTableGateway'   =>  function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Agendamento());
                    return new TableGateway('Agendamento', $dbAdapter, null, $resultSetPrototype);
                },
                'ConsultoresTable' =>  function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tableGateway = $sm->get('ConsultoresTableGateway');
                    $table = new ConsultoresTable($tableGateway, $dbAdapter);
                    return $table;
                },
                'ConsultoresTableGateway'   =>  function ($sm) {;
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Consultores());
                    return new TableGateway('Consultores', $dbAdapter, null, $resultSetPrototype);
                },
                'ServicosTable' =>  function ($sm) {
                    $tableGateway = $sm->get('ServicosTableGateway');
                    $table = new ServicosTable($tableGateway);
                    return $table;
                },
                'ServicosTableGateway'   =>  function ($sm) {;
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Servicos());
                    return new TableGateway('Servicos', $dbAdapter, null, $resultSetPrototype);
                },
                'AgendamentoService'   =>  function ($sm) {;
                    $agendaTable = $sm->get('AgendaTable');
                    $consultoresTable = $sm->get('ConsultoresTable');
                    return new AgendamentoService($agendaTable, $consultoresTable);
                },
            ),
        );
    }
}
