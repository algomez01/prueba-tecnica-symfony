<?php

namespace App\Entity;

use App\Repository\CitaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitaRepository::class)]
class Cita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $paciente = null;

    #[ORM\Column(length: 255)]
    private ?string $medico = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255)]
    private ?string $tipoCita = null;

    #[ORM\Column(length: 255)]
    private ?string $duracion = null;

    #[ORM\Column]
    private ?bool $CitaAtendida = null;

    #[ORM\Column]
    private ?int $valor = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

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

    public function getDuracion(): ?string
    {
        return $this->duracion;
    }

    public function setDuracion(string $duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function isCitaAtendida(): ?bool
    {
        return $this->CitaAtendida;
    }

    public function setCitaAtendida(bool $CitaAtendida): self
    {
        $this->CitaAtendida = $CitaAtendida;

        return $this;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(int $valor): self
    {
        $this->valor = $valor;

        return $this;
    }
}
