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
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'AgendaApi\Controller\Agendamento' => 'AgendaApi\Factory\AgendamentoControllerFactory'
        )
    ),
    'service_manager' => array(
        'invokables' => array(
            'AgendaApi\Service\AgendamentoServiceInterface' => 'AgendaApi\Service\AgendamentoService'
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'db' => array(
        'driver' => 'Pdo',
        'dsn'    => sprintf('sqlite:%s/data/banco.db', realpath(getcwd())),
    ),
);
