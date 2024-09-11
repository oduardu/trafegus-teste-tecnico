<?php

namespace Application\Controller;

use Core\Controller\DefaultController;

class VinculosController extends DefaultController
{
    public function indexAction()
    {
        $bonds = $this->getService(\Application\Service\VehicleService::class)->findAll();

        return viewModel(null, [
            'bonds' => $bonds
        ]);
    }

    public function saveAction()
    {
        $placa = $this->params()->fromRoute('placa', null);

        if (!empty($placa)) {
            $vehicle = $this->getService(\Application\Service\VehicleService::class)->find($placa);

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
                debug($response);
                return $this->resJson($response);
            }
        }


        return $this->resJson([
            'success' => false,
            'message' => 'Placa não informada.'
        ]);
    }
}
