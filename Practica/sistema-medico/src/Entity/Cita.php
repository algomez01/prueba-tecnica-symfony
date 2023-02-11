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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Fecha = null;

    #[ORM\Column(length: 255)]
    private ?string $TipoCita = null;

    #[ORM\Column(length: 255)]
    private ?string $Duracion = null;

    #[ORM\Column(length: 255)]
    private ?int $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->Fecha;
    }

    public function setFecha(\DateTimeInterface $Fecha): self
    {
        $this->Fecha = $Fecha;

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

    public function getDuracion(): ?string
    {
        return $this->Duracion;
    }

    public function setDuracion(string $Duracion): self
    {
        $this->Duracion = $Duracion;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserID(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
