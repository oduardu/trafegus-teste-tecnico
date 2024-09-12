<?php

namespace Application\Service;

use Core\Interfaces\Service\CrudServiceInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class BondVehiclesAndDrivers implements ServiceManagerAwareInterface, CrudServiceInterface
{

    protected $serviceManager;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function find($data)
    {
        try {

            $this->dataValidator($data);

            $entity = $this->serviceManager->get('Doctrine\ORM\EntityManager')->find(\Application\Model\BondVehiclesAndDrivers::class, ['cpf' => $data['cpf'], 'placa' => $data['placa']]);

            if (!$entity) {
                throw new \Exception('Vínculo não encontrado.');
            }

            return $entity;
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function findAll()
    {
        try {
            $entities = $this->serviceManager->get('Doctrine\ORM\EntityManager')->getRepository(\Application\Model\BondVehiclesAndDrivers::class)->findAll();

            return $entities;
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function save($data)
    {
        try {
            $this->dataValidator($data);

            $driver = $this->serviceManager->get(\Application\Service\DriverService::class)->find($data['cpf']);

            if (isset($driver['success']) && !$driver['success']) {
                throw new \Exception('Motorista não encontrado.');
            }

            $vehicle = $this->serviceManager->get(\Application\Service\VehicleService::class)->find($data['placa']);

            if (isset($vehicle['success']) && !$vehicle['success']) {
                throw new \Exception('Veículo não encontrado.');
            }

            $bond = new \Application\Model\BondVehiclesAndDrivers();

            $bond->setCpf($data['cpf']);
            $bond->setCpf($data['placa']);

            $this->serviceManager->get('Doctrine\ORM\EntityManager')->persist($bond);
            $this->serviceManager->get('Doctrine\ORM\EntityManager')->flush();

            return [
                'success' => true,
                'message' => 'Motorista salvo com sucesso.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function remove($data)
    {
        try {
            $this->dataValidator($data);

            $driver = $this->serviceManager->get(\Application\Service\DriverService::class)->find($data['cpf']);

            if (isset($driver['success']) && !$driver['success']) {
                throw new \Exception('Motorista não encontrado.');
            }

            $vehicle = $this->serviceManager->get(\Application\Service\VehicleService::class)->find($data['placa']);

            if (isset($vehicle['success']) && !$vehicle['success']) {
                throw new \Exception('Veículo não encontrado.');
            }


            $bond = $this->find($data);

            $this->serviceManager->get('Doctrine\ORM\EntityManager')->remove($bond);
            $this->serviceManager->get('Doctrine\ORM\EntityManager')->flush();

            return [
                'success' => true,
                'message' => 'Vínculo removido com sucesso.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function dataValidator(array $data)
    {
        $expectedKeys = ['placa', 'cpf'];
        $dataKeys = array_keys($data);
        sort($expectedKeys);
        sort($dataKeys);

        if (array_intersect($expectedKeys, $dataKeys) !== $expectedKeys) {
            throw new \Exception('Parâmetros inválidos, deve ser informado: ' . implode(', ', $expectedKeys) . ', foi informado: ' . implode(', ', $dataKeys));
        }

        $problemas = [];

        foreach ($data as $key => $value) {
            if ($key == 'cpf' && !$this->validCpf($value)) {
                $problemas[] = 'CPF inválido.';
            }

            if ($key == 'placa' && !preg_match('/^[a-zA-Z0-9]{7}$/', $value)) {
                $problemas[] = 'Placa inválida';
            }
        }

        if ($problemas) {
            throw new \Exception(implode('\n ', $problemas));
        }
    }


    private function validCpf($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}