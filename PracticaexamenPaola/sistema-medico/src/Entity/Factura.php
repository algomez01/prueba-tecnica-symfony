<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturaRepository::class)
 */
class Factura
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
    private $fecha_creacion;

    /**
     * @ORM\Column(type="float")
     */
    private $totalpagar;

    /**
     * @ORM\Column(type="integer")
     */
    private $cajeroId;

    /**
     * @ORM\Column(type="integer")
     */
    private $citaId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): self
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getTotalpagar(): ?float
    {
        return $this->totalpagar;
    }

    public function setTotalpagar(float $totalpagar): self
    {
        $this->totalpagar = $totalpagar;

        return $this;
    }

    public function getCajeroId(): ?int
    {
        return $this->cajeroId;
    }

    public function setCajeroId(int $cajeroId): self
    {
        $this->cajeroId = $cajeroId;

        return $this;
    }

    public function getCitaId(): ?int
    {
        return $this->citaId;
    }

    public function setCitaId(int $citaId): self
    {
        $this->citaId = $citaId;

        return $this;
    }
}
