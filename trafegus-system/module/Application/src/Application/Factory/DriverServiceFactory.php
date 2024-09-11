<?php

namespace Application\Factory;

use Application\Service\DriverService;
use Zend\ServiceManager\ServiceLocatorInterface;

class DriverServiceFactory implements \Zend\ServiceManager\FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new DriverService($serviceLocator);
    }
}