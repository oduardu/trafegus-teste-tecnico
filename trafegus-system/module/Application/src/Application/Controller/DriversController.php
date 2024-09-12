<?php

namespace Application\Controller;

use Core\Controller\DefaultController;

class DriversController extends DefaultController
{
    public function indexAction()
    {
        $drivers = $this->getService(\Application\Service\DriverService::class)->searchDriversInfo();

        return viewModel(null, [
            'drivers' => $drivers
        ]);
    }

    public function saveAction()
    {
        $cpf = $this->getRequest()->getQuery('cpf');
        $driver = null;

        if (!empty($cpf)) {
            $driver = $this->getService(\Application\Service\DriverService::class)->find($cpf, true);

            if (is_array($driver) && isset($driver['success'])) {
                return $this->resJson($driver);
            }
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $response = $this->getService(\Application\Service\DriverService::class)->save($data);

            return $this->resJson($response);
        }

        return viewModel(null,[
            'driver' => $driver
        ]);
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $cpf = $data['cpf'];

            if (!empty($cpf)) {
                $response = $this->getService(\Application\Service\DriverService::class)->remove($cpf);

                return $this->resJson($response);
            }
        }

        return $this->resJson([
            'success' => false,
            'message' => 'CPF não informado.'
        ]);
    }

}
