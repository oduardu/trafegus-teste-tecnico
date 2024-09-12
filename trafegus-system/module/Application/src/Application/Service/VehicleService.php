<?php

namespace Application\Service;

use Core\Interfaces\Service\CrudServiceInterface;
use Core\Service\AbstractService;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class VehicleService extends AbstractService implements CrudServiceInterface
{


    public function find($placa, $array = false)
    {
        try {
            $entity = $this->getService('Doctrine\ORM\EntityManager')->find(\Application\Model\Vehicles::class, $placa);

            if (!$entity) {
                throw new \Exception('Veículo não encontrado.');
            }

            return $array ? $entity->toArr() : $entity;
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
            $entities = $this->getService('Doctrine\ORM\EntityManager')->getRepository(\Application\Model\Vehicles::class)->findAll();

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

            $vehicle = $this->find($data['placa']);

            if (is_array($vehicle) && !$vehicle['success']) {
                $vehicle = new \Application\Model\Vehicles();
                $vehicle->setPlaca($data['placa']);
            }

            $vehicle->setModelo($data['modelo']);
            $vehicle->setMarca($data['marca']);
            $vehicle->setAno($data['ano']);
            $vehicle->setCor($data['cor']);

            $EntityManager = $this->getService('Doctrine\ORM\EntityManager');
            $EntityManager->persist($vehicle);
            $EntityManager->flush();

            return [
                'success' => true,
                'message' => 'Veículo salvo com sucesso.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

    }

    public function remove($placa)
    {
        try {
            $entity = $this->find($placa);

            if (is_array($entity) && !$entity['success']) {
                return $entity;
            }

            $EntityManager = $this->getService('Doctrine\ORM\EntityManager');
            $EntityManager->remove($entity);
            $EntityManager->flush();

            return [
                'success' => true,
                'message' => 'Veículo removido com sucesso.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function searchVehiclesInfo()
    {
        $vehicles = $this->findAll(true);
        $drivers = $this->getService(\Application\Service\DriverService::class)->findAll(true);

        $vehicles = array_combine(
            array_map(function($vehicle) {
                return $vehicle['placa'];
            }, $vehicles),
            $vehicles
        );

        $drivers = array_combine(
            array_map(function($drivers) {
                return $drivers['cpf'];
            }, $drivers),
            $drivers
        );

        $bonds = $this->getService(\Application\Service\BondVehiclesAndDrivers::class)->findAll(true);
        foreach ($bonds as $bond) {
            if(isset($vehicles[$bond['vehicle_placa']])) {
                $vehicles[$bond['vehicle_placa']]['drivers'][] = $drivers[$bond['driver_cpf']]['nome'];
            };
        }

        return $vehicles;
    }


    private function dataValidator(array $data)
    {
        $expectedKeys = ['placa', 'modelo', 'marca', 'ano', 'cor'];
        $dataKeys = array_keys($data);
        sort($expectedKeys);
        sort($dataKeys);

        if (array_intersect($expectedKeys, $dataKeys) !== $expectedKeys) {
            throw new \Exception('Parâmetros inválidos, deve ser informado: <b>' . implode(', ', $expectedKeys) . '</b>, foi informado: <b>' . implode(', ', $dataKeys) . '</b>');
        }

        $problemas = [];

        foreach ($data as $key => $value) {
            if ($key == 'placa' && !preg_match('/^[a-zA-Z0-9]{7}$/', $value)) {
                $problemas[] = 'Placa inválida';
            }

            if ($key == 'modelo' && !preg_match('/^[a-zA-Z0-9]+$/', $value)) {
                $problemas[] = 'Modelo inválido';
            }

            if ($key == 'marca' && !preg_match('/^[a-zA-Z0-9]+$/', $value)) {
                $problemas[] = 'Marca inválida';
            }

            if ($key == 'ano' && !preg_match('/^[0-9]{4}$/', $value)) {
                $problemas[] = 'Ano inválido';
            }

            if ($key == 'cor' && !preg_match('/^[a-zA-Z0-9]+$/', $value)) {
                $problemas[] = 'Cor inválida';
            }
        }

        if ($problemas) {
            throw new \Exception(implode('\n ', $problemas));
        }
    }
}