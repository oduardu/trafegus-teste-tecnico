<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="vehicles")
 */
class Vehicles
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=7, nullable=false, unique=true)
     */
    protected $placa;

    /**
     * @ORM\Column(type="string", length=30, nullable=true, unique=true)
     */
    protected $renavam;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    protected $modelo;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    protected $marca;

    /**
     * @ORM\Column(type="decimal", nullable=false)
     */
    protected $ano;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    protected $cor;

    public function getPlaca()
    {
        return $this->placa;
    }

    public function getRenavam()
    {
        return $this->renavam;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function getCor()
    {
        return $this->cor;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    public function setRenavam($renavam)
    {
        $this->renavam = $renavam;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    public function setCor($cor)
    {
        $this->cor = $cor;
    }

    public function toArr()
    {
        return get_object_vars($this);
    }
}