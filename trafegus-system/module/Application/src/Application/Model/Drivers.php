<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

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

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

}