<?php

namespace Application\Factory;

use Application\Service\VehicleService;
use Zend\ServiceManager\ServiceLocatorInterface;

class VehicleServiceFactory implements \Zend\ServiceManager\FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new VehicleService($serviceLocator);
    }
}