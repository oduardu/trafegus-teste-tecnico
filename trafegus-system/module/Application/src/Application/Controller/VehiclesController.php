<?php

namespace Application\Controller;

use Core\Controller\DefaultController;

class VehiclesController extends DefaultController
{
    public function indexAction()
    {
        $vehicles = $this->getService(\Application\Service\VehicleService::class)->searchVehiclesInfo();

        return viewModel(null, [
            'vehicles' => $vehicles
        ]);
    }

    public function saveAction()
    {
        $placa = $this->getRequest()->getQuery('placa');

        if (!empty($placa)) {
            $vehicle = $this->getService(\Application\Service\VehicleService::class)->find($placa, true);

            if (isset($vehicle['success']) && !$vehicle['success']) {
                return $this->resJson($vehicle);
            }
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $response = $this->getService(\Application\Service\VehicleService::class)->save($data);

            return $this->resJson($response);
        }

        return viewModel(null,[
            'vehicle' => $vehicle
        ]);
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $placa = $data['placa'];

            if (!empty($placa)) {
                $response = $this->getService(\Application\Service\VehicleService::class)->remove($placa);

                return $this->resJson($response);
            }
        }


        return $this->resJson([
            'success' => false,
            'message' => 'Placa não informada.'
        ]);
    }
}
