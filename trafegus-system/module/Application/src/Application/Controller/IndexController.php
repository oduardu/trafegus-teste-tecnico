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
//        $response = $this->getService(\Application\Service\DriverService::class)->save([
//            'nome' => 'Eduardo Pazzini Zancanaro',
//            'cpf' => '09379348959',
//            'rg' => '116753808',
//            'telefone' => '49991861581',
//        ]);
//
//        return $this->resJson($response);

        return viewModel();
    }
}
