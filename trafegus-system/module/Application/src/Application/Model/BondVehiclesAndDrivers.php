<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="driver_vehicle")
 */
class BondVehiclesAndDrivers
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=11, nullable=false, unique=true)
     */
    protected $driver_cpf;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30, nullable=false, unique=true)
     */
    protected $vehicle_placa;

    public function getDriverCpf()
    {
        return $this->driver_cpf;
    }

    public function getVehiclePlaca()
    {
        return $this->vehicle_placa;
    }
    public function setDriverCpf($cpf)
    {
        $this->driver_cpf = $cpf;
    }

    public function setVehiclePlaca($placa)
    {
        $this->vehicle_placa = $placa;
    }

    public function toArr()
    {
        return get_object_vars($this);
    }
}