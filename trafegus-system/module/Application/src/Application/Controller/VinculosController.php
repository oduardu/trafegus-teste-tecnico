<?php

namespace Application\Controller;

use Core\Controller\DefaultController;

class VinculosController extends DefaultController
{
    public function saveAction()
    {
        $placa = $this->params()->fromRoute('placa', null);
        $cpf = $this->params()->fromRoute('cpf', null);

//        $vehicles = $this->getService(\Application\Service\VehicleService::class)->findAll();
//
//        if (isset($vehicles['success']) && !$vehicles['success']) {
//            return $this->resJson($vehicles);
//        }
//
//        $drivers = $this->getService(\Application\Service\DriverService::class)->findAll();
//
//        if (isset($drivers['success']) && !$drivers['success']) {
//            return $this->resJson($drivers);
//        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $response = $this->getService(\Application\Service\BondVehiclesAndDrivers::class)->save($data);

            return $this->resJson($response);
        }

        return viewModel(null,[
//            'vehicle' => $vehicles->toArray() ?? [],
//            'drivers' => $drivers->toArray() ?? [],
            'vehicle' => [],
            'drivers' => [],
            'placa' => $placa,
            'cpf' => $cpf,
        ]);
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

           $response = $this->getService(\Application\Service\BondVehiclesAndDrivers::class)->remove($data);

            return $this->resJson($response);
        }

        return $this->resJson([
            'success' => false,
            'message' => 'Requisição inválida!'
        ]);
    }
}
