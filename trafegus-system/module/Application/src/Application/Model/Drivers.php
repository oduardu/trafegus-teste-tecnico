<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;
use Core\Model\AbstractModel;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity
 * @ORM\Table(name="drivers")
 */
class Drivers
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=11, nullable=false, unique=true)
     */
    protected $cpf;

    /**
     * @ORM\Column(type="string", length=20, nullable=false, unique=true)
     */
    protected $rg;

    /**
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    protected $nome;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $telefone;

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException("ID cannot be empty");
        }
        return $this->entityManager->find(self::class, $id);
    }

    public function fetchAll()
    {
        return $this->entityManager->getRepository(self::class)->findAll();
    }

    public function save($entity)
    {
        if (empty($entity)) {
            throw new \InvalidArgumentException("Entity cannot be empty");
        }
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete($entity)
    {
        if (empty($entity)) {
            throw new \InvalidArgumentException("Entity cannot be empty");
        }
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function setData(array $data)
    {
        if(empty($data['cpf']) || empty($data['rg']) || empty($data['nome'])) {
            throw new \InvalidArgumentException("Parâmetros inválidos");
        }

        $this->cpf = $data['cpf'];
        $this->rg = $data['rg'];
        $this->nome = $data['nome'];
        $this->telefone = $data['telefone'];
    }
}