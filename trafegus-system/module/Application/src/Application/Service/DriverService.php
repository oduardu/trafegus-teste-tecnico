<?php

namespace Application\Service;

use Core\Interfaces\Service\CrudServiceInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class DriverService implements ServiceManagerAwareInterface, CrudServiceInterface
{

    protected $serviceManager;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function find($cpf)
    {
        try {
            $entity = $this->serviceManager->get('Doctrine\ORM\EntityManager')->find(\Application\Model\Drivers::class, $cpf);

            if (!$entity) {
                throw new \Exception('Motorista não encontrado.');
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
            $entities = $this->serviceManager->get('Doctrine\ORM\EntityManager')->getRepository(\Application\Model\Drivers::class)->findAll();

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

            if (isset($driver['success']) && !$driver['success']) {
                $driver = new \Application\Model\Drivers();
                $driver->setCpf($data['cpf']);
            }

            $driver->setRg($data['rg']);
            $driver->setNome($data['nome']);
            $driver->setTelefone($data['telefone']);

            $this->serviceManager->get('Doctrine\ORM\EntityManager')->persist($driver);
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

    public function remove($cpf)
    {
        try {
            $driver = $this->find($cpf);

            $this->serviceManager->get('Doctrine\ORM\EntityManager')->remove($driver);
            $this->serviceManager->get('Doctrine\ORM\EntityManager')->flush();

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