<?php

namespace Application\Service;

use Core\Interfaces\Service\CrudServiceInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class VehicleService implements ServiceManagerAwareInterface, CrudServiceInterface
{

    protected $serviceManager;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function find($placa)
    {
        try {
            $entity = $this->serviceManager->get('Doctrine\ORM\EntityManager')->find(\Application\Model\Vehicles::class, $placa);

            if (!$entity) {
                throw new \Exception('Veículo não encontrado.');
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
            $entities = $this->serviceManager->get('Doctrine\ORM\EntityManager')->getRepository(\Application\Model\Vehicles::class)->findAll();

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

            if (isset($vehicleFind['success']) && !$vehicleFind['success']) {
                $vehicle = new \Application\Model\Vehicles();
                $vehicle->setPlaca($data['placa']);
            }

            $vehicle->setModelo($data['modelo']);
            $vehicle->setMarca($data['marca']);
            $vehicle->setAno($data['ano']);
            $vehicle->setCor($data['cor']);

            $this->serviceManager->get('Doctrine\ORM\EntityManager')->persist($vehicle);
            $this->serviceManager->get('Doctrine\ORM\EntityManager')->flush();

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

            if (isset($entity['success']) && !$entity['success']) {
                return $entity;
            }

            $this->serviceManager->get('Doctrine\ORM\EntityManager')->remove($entity);
            $this->serviceManager->get('Doctrine\ORM\EntityManager')->flush();

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
        $vehicles = $this->findAll()->toArray();
        $drivers = $this->findAll()->toArray();

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

        $bonds = $this->serviceManager->get('Doctrine\ORM\EntityManager')->getRepository(\Application\Model\VehiclesDrivers::class)->findAll()->toArray();

        foreach ($bonds as $bond) {
            if(isset($vehicles[$bond['placa']])) {
                $vehicles[$bond['placa']]['drivers'][] = $drivers[$bond['cpf']]['nome'];
            };
        }
        
    }


    private function dataValidator(array $data)
    {
        $expectedKeys = ['placa', 'modelo', 'marca', 'ano', 'cor'];
        $dataKeys = array_keys($data);
        sort($expectedKeys);
        sort($dataKeys);

        if ($dataKeys != $expectedKeys) {
            throw new \Exception('Parâmetros inválidos, deve ser informado' . implode(', ', $expectedKeys) . ', foi informado: ' . implode(', ', $dataKeys));
        }

        $problemas = [];

        foreach ($data as $key => $value) {
            if ($key == 'placa' && !preg_match('/^[a-zA-Z0-9]{7}$/', $value)) {
                $problemas[] = 'Placa inválida';
            }

            if ($key == 'modelo' && !preg_match('/^[a-zA-Z0-9]{20}$/', $value)) {
                $problemas[] = 'Modelo inválido';
            }

            if ($key == 'marca' && !preg_match('/^[a-zA-Z0-9]{20}$/', $value)) {
                $problemas[] = 'Marca inválida';
            }

            if ($key == 'ano' && !preg_match('/^[0-9]{4}$/', $value)) {
                $problemas[] = 'Ano inválido';
            }

            if ($key == 'cor' && !preg_match('/^[a-zA-Z0-9]{20}$/', $value)) {
                $problemas[] = 'Cor inválida';
            }
        }

        if ($problemas) {
            throw new \Exception(implode('\n ', $problemas));
        }
    }
}