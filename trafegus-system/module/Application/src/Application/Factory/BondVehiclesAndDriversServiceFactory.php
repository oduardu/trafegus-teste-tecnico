<?php

namespace Application\Factory;

use Application\Service\BondVehiclesAndDrivers;
use Zend\ServiceManager\ServiceLocatorInterface;

class BondVehiclesAndDriversServiceFactory implements \Zend\ServiceManager\FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new BondVehiclesAndDrivers($serviceLocator);
    }
}