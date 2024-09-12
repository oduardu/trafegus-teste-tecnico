<?php

namespace Application\Service;

use Core\Interfaces\Service\CrudServiceInterface;
use Core\Service\AbstractService;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class BondVehiclesAndDrivers extends AbstractService implements CrudServiceInterface
{

    public function find($data)
    {
        try {

            $this->dataValidator($data);

            $entity = $this->getService('Doctrine\ORM\EntityManager')->find(\Application\Model\BondVehiclesAndDrivers::class, ['driver_cpf' => $data['cpf'], 'vehicle_placa' => $data['placa']]);

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

    public function findAll($array = false)
    {
        try {
            $entities = $this->getService('Doctrine\ORM\EntityManager')->getRepository(\Application\Model\BondVehiclesAndDrivers::class)->findAll();

            if ($array) {
                $arrayEntities = [];

                foreach ($entities as $entity) {
                    $arrayEntities[] = $entity->toArr();
                }

                return $arrayEntities;
            }

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

            $driver = $this->getService(\Application\Service\DriverService::class)->find($data['cpf']);

            if (is_array($driver) && !$driver['success']) {
                throw new \Exception('Motorista não encontrado.');
            }

            $vehicle = $this->getService(\Application\Service\VehicleService::class)->find($data['placa']);

            if (is_array($vehicle) && !$vehicle['success']) {
                throw new \Exception('Veículo não encontrado.');
            }

            $bond = new \Application\Model\BondVehiclesAndDrivers();

            $bond->setDriverCpf($data['cpf']);
            $bond->setVehiclePlaca($data['placa']);

            $EntityManager = $this->getService('Doctrine\ORM\EntityManager');
            $EntityManager->persist($bond);
            $EntityManager->flush();

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

            $driver = $this->getService(\Application\Service\DriverService::class)->find($data['cpf']);

            if (is_array($driver) && !$driver['success']) {
                throw new \Exception('Motorista não encontrado.');
            }

            $vehicle = $this->getService(\Application\Service\VehicleService::class)->find($data['placa']);

            if (is_array($vehicle) && !$vehicle['success']) {
                throw new \Exception('Veículo não encontrado.');
            }


            $bond = $this->find([
                'cpf' => $data['cpf'],
                'placa' => $data['placa']
            ]);

            $EntityManager = $this->getService('Doctrine\ORM\EntityManager');
            $EntityManager->remove($bond);
            $EntityManager->flush();

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

    public function findAllBondWithInfo()
    {
        $select = new \Doctrine\DBAL\Query\QueryBuilder($this->getService('Doctrine\ORM\EntityManager')->getConnection());

        $select->select('d.cpf', 'd.nome', 'v.placa', 'v.modelo', 'v.marca')
            ->from('driver_vehicle')
            ->join('driver_vehicle', 'drivers', 'd', 'driver_vehicle.driver_cpf = d.cpf')
            ->join('driver_vehicle', 'vehicles', 'v', 'driver_vehicle.vehicle_placa = v.placa');

        $result = $select->execute()->fetchAll();

        return $result;
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