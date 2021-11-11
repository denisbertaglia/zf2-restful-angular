<?php

return array(
    'router' => array(
        'routes' => array(
            'agenda' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/v1/agendamento[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AgendaApi\Controller\Agendamento',
                    ),
                ),
            ),
            'servicos' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/v1/servicos[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AgendaApi\Controller\Servicos',
                    ),
                ),
            ),
            'consultores' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/v1/consultores[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
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
