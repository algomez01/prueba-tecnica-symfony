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
    private $fe_creacion;

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
    private $tipo_cita_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $paciente_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $medico_id;
    const ESTADO_PENDIENTE = 'Pendiente';
    const ESTADO_ATENDIDA = 'Atendida';
    const ESTADO_FACTURADA = 'Facturada';
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

    public function getTipoCitaId(): ?int
    {
        return $this->tipo_cita_id;
    }

    public function setTipoCitaId(int $tipo_cita_id): self
    {
        $this->tipo_cita_id = $tipo_cita_id;

        return $this;
    }

    public function getPacienteId(): ?int
    {
        return $this->paciente_id;
    }

    public function setPacienteId(int $paciente_id): self
    {
        $this->paciente_id = $paciente_id;

        return $this;
    }

    public function getMedicoId(): ?int
    {
        return $this->medico_id;
    }

    public function setMedicoId(int $medico_id): self
    {
        $this->medico_id = $medico_id;

        return $this;
    }
}
