<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
class Factura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255)]
    private ?string $total = null;

    #[ORM\Column(length: 255)]
    private ?string $paciente = null;

    #[ORM\Column(length: 255)]
    private ?string $medico = null;

    #[ORM\Column(length: 255)]
    private ?string $tipoCita = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getPaciente(): ?string
    {
        return $this->paciente;
    }

    public function setPaciente(string $paciente): self
    {
        $this->paciente = $paciente;

        return $this;
    }

    public function getMedico(): ?string
    {
        return $this->medico;
    }

    public function setMedico(string $medico): self
    {
        $this->medico = $medico;

        return $this;
    }

    public function getTipoCita(): ?string
    {
        return $this->tipoCita;
    }

    public function setTipoCita(string $tipoCita): self
    {
        $this->tipoCita = $tipoCita;

        return $this;
    }
}
