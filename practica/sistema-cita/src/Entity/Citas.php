<?php

namespace App\Entity;

use App\Repository\CitasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitasRepository::class)]
class Citas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255)]
    private ?string $hora = null;

    #[ORM\Column(length: 255)]
    private ?string $duracion = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\Column(length: 255)]
    private ?string $TipoCita = null;

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

    public function getHora(): ?string
    {
        return $this->hora;
    }

    public function setHora(string $hora): self
    {
        $this->hora = $hora;

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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getTipoCita(): ?string
    {
        return $this->TipoCita;
    }

    public function setTipoCita(string $TipoCita): self
    {
        $this->TipoCita = $TipoCita;

        return $this;
    }
}
