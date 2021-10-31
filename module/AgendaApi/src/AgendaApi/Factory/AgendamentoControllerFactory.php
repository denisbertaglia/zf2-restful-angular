<?php
namespace AgendaApi\Factory;

use AgendaApi\Controller\AgendamentoController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AgendamentoControllerFactory  implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {   
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $agendaService        = $realServiceLocator->get('AgendaApi\Service\AgendamentoServiceInterface');
        return new AgendamentoController($agendaService);
    }
}