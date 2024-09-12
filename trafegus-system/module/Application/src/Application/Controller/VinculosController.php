<?php

namespace Application\Controller;

use Core\Controller\DefaultController;

class VinculosController extends DefaultController
{

    public function indexAction()
    {
        $bonds = $this->getService(\Application\Service\BondVehiclesAndDrivers::class)->findAllBondWithInfo();

        return viewModel(null, [
            'bonds' => $bonds
        ]);
    }

    public function saveAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $response = $this->getService(\Application\Service\BondVehiclesAndDrivers::class)->save($data);

            return $this->resJson($response);
        }

        $vehicles = $this->getService(\Application\Service\VehicleService::class)->findAll(true);

        if (isset($vehicles['success']) && !$vehicles['success']) {
            return $this->resJson($vehicles);
        }

        $drivers = $this->getService(\Application\Service\DriverService::class)->findAll(true);

        if (isset($drivers['success']) && !$drivers['success']) {
            return $this->resJson($drivers);
        }

        return viewModel(null,[
            'drivers' => $drivers,
            'vehicles' => $vehicles,
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
