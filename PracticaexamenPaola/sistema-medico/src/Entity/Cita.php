<?php

namespace App\Entity;

use App\Repository\CitaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CitaRepository::class)
 */
class Cita
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
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $tipoCitaId;

    /**
     * @ORM\Column(type="integer")
     */
    private $pacienteId;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $doctorId;
    const ESTADO_ENESPERA = 'ENESPERA';
    const ESTADO_ATENDIDA = 'Atendida';
    const ESTADO_FACTURADA = 'Facturada';

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getTipoCitaId(): ?int
    {
        return $this->tipoCitaId;
    }

    public function setTipoCitaId(int $tipoCitaId): self
    {
        $this->tipoCitaId = $tipoCitaId;

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

    public function getDoctorId(): ?int
    {
        return $this->doctorId;
    }

    public function setDoctorId(int $doctorId): self
    {
        $this->doctorId = $doctorId;

        return $this;
    }
}
