<?php

namespace Application\Controller;

use Core\Controller\DefaultController;

class DriversController extends DefaultController
{
    public function indexAction()
    {

        $drivers = [
            [
                'cpf' => '12345678901',
                'rg' => '1234567',
                'nome' => 'João da Silva',
                'telefone' => '123456789'
            ],
            [
                'cpf' => '98765432109',
                'rg' => '7654321',
                'nome' => 'Maria da Silva',
                'telefone' => '987654321'
            ]
        ];

        return viewModel(null, [
            'drivers' => $drivers
        ]);
    }
}
