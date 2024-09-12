<?php

namespace Application\Controller;

use Application\Model\Drivers;
use Core\Controller\DefaultController;
use Doctrine\ORM\EntityManager;

class IndexController extends DefaultController
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $drivers = $this->getService(\Application\Service\BondVehiclesAndDrivers::class)->findAllBondWithInfo();
        $config = $this->getService('Configuration');

        return viewModel(null, [
            'drivers' => $drivers,
            'key' => $config['API_GOOGLE_KEY']
        ]);
    }
}
