<?php

namespace App\Entity;

use App\Repository\CitasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CitasRepository::class)
 */
class Citas
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
     * @ORM\Column(type="string", length=255)
     */
    private $motivo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    /**
     * @ORM\Column(type="integer")
     */
    private $pacienteId;

    /**
     * @ORM\Column(type="integer")
     */
    private $medicoId;

    /**
     * @ORM\Column(type="integer")
     */
    private $tipoCitaId;

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

    public function getMotivo(): ?string
    {
        return $this->motivo;
    }

    public function setMotivo(string $motivo): self
    {
        $this->motivo = $motivo;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getPacienteId(): ?int
    {
        return $this->pacienteId;
    }

    public function setPacienteId(int $pacienteId): self
    {
        $this->pacienteId = $pacienteId;

        return $this;
    }

    public function getMedicoId(): ?int
    {
        return $this->medicoId;
    }

    public function setMedicoId(int $medicoId): self
    {
        $this->medicoId = $medicoId;

        return $this;
    }

    public function getTipoCitaId(): ?int
    {
        return $this->tipoCitaId;
    }

    public function setTipoCitaId(int $tipoCitaId): self
    {
        $this->tipoCitaId = $tipoCitaId;

        return $this;
    }
}