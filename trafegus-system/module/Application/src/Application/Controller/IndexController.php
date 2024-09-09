<?php

namespace Application\Controller;

use Application\Model\Drivers;
use Core\Controller\DefaultController;
use Doctrine\ORM\EntityManager;

class IndexController extends DefaultController
{

    public function indexAction()
    {
        $entityManager = $this->getService(EntityManager::class);
        $driver = new Drivers($entityManager);

        $data = [
            'cpf' => '12345678901',
            'rg' => 'MG1234567',
            'nome' => 'João da Silva',
            'telefone' => '31987654321'
        ];

        $driver->setData($data);
        $driver->save($driver);
    }
}
