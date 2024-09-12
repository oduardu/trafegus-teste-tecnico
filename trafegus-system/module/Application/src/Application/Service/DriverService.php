<?php

namespace Application\Service;

use Core\Interfaces\Service\CrudServiceInterface;
use Core\Service\AbstractService;

class DriverService extends AbstractService implements CrudServiceInterface
{

    public function find($cpf, $array = false)
    {
        try {
            $entity = $this->getService('Doctrine\ORM\EntityManager')->find(\Application\Model\Drivers::class, $cpf);

            if (!$entity) {
                throw new \Exception('Motorista não encontrado.');
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
            $entities = $this->getService('Doctrine\ORM\EntityManager')->getRepository(\Application\Model\Drivers::class)->findAll();

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

            $driver = $this->find($data['cpf']);

            if (is_array($driver) && !$driver['success']) {
                $driver = new \Application\Model\Drivers();
                $driver->setCpf($data['cpf']);
            }

            $driver->setRg($data['rg']);
            $driver->setNome($data['nome']);
            $driver->setTelefone($data['telefone']);


            $EntityManager = $this->getService('Doctrine\ORM\EntityManager');
            $EntityManager->persist($driver);
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

    public function remove($cpf)
    {
        try {
            $driver = $this->find($cpf);

            $this->getService('Doctrine\ORM\EntityManager')->remove($driver);
            $this->getService('Doctrine\ORM\EntityManager')->flush();

            return [
                'success' => true,
                'message' => 'Motorista removido com sucesso.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function searchDriversInfo()
    {
        $drivers = $this->findAll(true);
        $vehicles = $this->getService(\Application\Service\VehicleService::class)->findAll(true);

        $drivers = array_combine(
            array_map(function($drivers) {
                return $drivers['cpf'];
            }, $drivers),
            $drivers
        );

        $vehicles = array_combine(
            array_map(function($vehicle) {
                return $vehicle['placa'];
            }, $vehicles),
            $vehicles
        );

        $bonds = $this->getService(\Application\Service\BondVehiclesAndDrivers::class)->findAll(true);

        foreach ($bonds as $bond) {
            if(isset($drivers[$bond['driver_cpf']])) {
                $drivers[$bond['driver_cpf']]['vehicles'][] = "({$vehicles[$bond['vehicle_placa']]['placa']}) - {$vehicles[$bond['vehicle_placa']]['marca']} {$vehicles[$bond['vehicle_placa']]['modelo']}";
            };
        }

        return $drivers;
    }

    private function dataValidator(array $data)
    {
        $expectedKeys = ['cpf', 'rg', 'nome'];
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

            if ($key == 'rg' && !preg_match('/\d/', $value)) {
                $problemas[] = 'RG inválido.';
            }

            if ($key == 'nome' && !preg_match('/^[a-zA-Z\s]{3,}$/', $value)) {
                $problemas[] = 'Nome inválido.';
            }

            if ($key == 'telefone' && !preg_match('/\d{9,11}/', $value)) {
                $problemas[] = 'Telefone inválido.';
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