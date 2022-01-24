<?php

return array(
    'router' => array(
        'routes' => array(
            'agenda' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/v1/agendamento',
                    'defaults' => array(
                        'controller' => 'AgendaApi\Controller\Agendamento',
                    ),
                ),
            ),
            'servicos' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/v1/servicos',
                    'defaults' => array(
                        'controller' => 'AgendaApi\Controller\Servicos',
                    ),
                ),
            ),
            'consultores' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/v1/consultores',
                    'defaults' => array(
                        'controller' => 'AgendaApi\Controller\Consultores',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'AgendaApi\Controller\Agendamento' => 'AgendaApi\Controller\AgendamentoController',
            'AgendaApi\Controller\Servicos' => 'AgendaApi\Controller\ServicosController',
            'AgendaApi\Controller\Consultores' => 'AgendaApi\Controller\ConsultoresController',
        )
    ),
    'db' => array(
        'driver' => 'Pdo',
        'dsn'    => sprintf('sqlite:%s/data/banco.db', realpath(getcwd())),
    ),
    'service_manager' => array(
        'invokables' => array(
            'AgendaApi\Service\AgendamentoServiceInterface' => 'AgendaApi\Service\AgendamentoService'
        ),
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
            => 'Zend\Db\Adapter\AdapterServiceFactory',
        )
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
