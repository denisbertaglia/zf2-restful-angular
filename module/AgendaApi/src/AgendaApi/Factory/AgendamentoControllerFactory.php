<?php
namespace AgendaApi\Factory;

use AgendaApi\Controller\AgendamentoController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AgendamentoControllerFactory  implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        
        //$realServiceLocator = $serviceLocator->getServiceLocator();
        $agendaService        = $serviceLocator->get('AgendaApi\Service\AgendamentoServiceInterface');
        return new AgendamentoController($agendaService);
    }
}