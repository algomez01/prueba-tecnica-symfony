<?php

namespace App\Entity;

use App\Repository\TipoCitaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TipoCitaRepository::class)
 */
class TipoCita
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="integer")
     */
    private $costo;
    /**
     * @ORM\Column(type="time")
     */
    private $minutos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getCosto(): ?int
    {
        return $this->costo;
    }

    public function setCosto(int $costo): self
    {
        $this->costo = $costo;

        return $this;
    }

    public function getMinutos(): ?\DateTime
    {
        return $this->minutos;
    }

    public function setMinutos(\DateTime $minutos): self
    {
        $this->minutos = $minutos;

        return $this;
    }
}
