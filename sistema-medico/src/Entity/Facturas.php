<?php

namespace App\Entity;

use App\Repository\FacturasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturasRepository::class)
 */
class Facturas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fe_creacion;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="integer")
     */
    private $cita_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cajero_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFeCreacion(): ?\DateTimeInterface
    {
        return $this->fe_creacion;
    }

    public function setFeCreacion(\DateTimeInterface $fe_creacion): self
    {
        $this->fe_creacion = $fe_creacion;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCitaId(): ?int
    {
        return $this->cita_id;
    }

    public function setCitaId(int $cita_id): self
    {
        $this->cita_id = $cita_id;

        return $this;
    }

    public function getCajeroId(): ?int
    {
        return $this->cajero_id;
    }

    public function setCajeroId(int $cajero_id): self
    {
        $this->cajero_id = $cajero_id;

        return $this;
    }
}
