<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;
use Core\Model\AbstractModel;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity
 * @ORM\Table(name="drivers")
 */
class Drivers extends AbstractModel
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

    public function __construct(EntityManager $entityManager, array $data = null)
    {
        parent::__construct($entityManager, self::class);

        if (!empty($data)) {
            $this->setData($data);
        }
    }

    public function getDrivers()
    {
        return $this->findAll();
    }

    public function getDriver($id)
    {
        return $this->find($id);
    }

    public function saveDriver($driver)
    {
        $this->save($driver);
    }

    public function removeDriver($driver)
    {
        $this->remove($driver);
    }

    public function toArrayDriver($driver)
    {
        return $this->toArray($driver);
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